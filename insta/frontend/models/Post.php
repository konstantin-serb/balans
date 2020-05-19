<?php

namespace frontend\models;

use frontend\models\events\PostCreatedEvent;
use Yii;
use frontend\models\User;
use yii\data\Pagination;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $user_id
 * @property string $filename
 * @property string|null $description
 * @property int $created_at
 * @property int $updated_at
 * @property int status
 * @property string complaints
 * @property int complaints_count
 *
 * @property User $user
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    public function rules()
    {
        return [
            [['description'], 'safe'],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'filename' => 'Filename',
            'description' => 'Description',
            'created_at' => 'Created At',
        ];
    }

    public function getImage()
    {
        return Yii::$app->storage->getFile($this->filename);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    public function like(User $currentUser)
    {
        $user = User::findOne($currentUser->getId());
        $idPost = $this->id;
        $model = new Likes();
        $likes = $model->find()->where(['post_id' => $idPost])->one();

        if (empty($user->likes)) {
            $user->likes = serialize([$idPost]);
            $sql = "UPDATE user SET likes = '$user->likes' WHERE id  = '$user->id'";
            Yii::$app->db->createCommand($sql)->execute();
        } else {
            $currentPostArray = unserialize($user->likes);
            if (!in_array($idPost, $currentPostArray)) {
                array_push($currentPostArray, $idPost);
                $user->likes = serialize($currentPostArray);
                $sql = "UPDATE user SET likes = '$user->likes' WHERE id  = '$user->id'";
                Yii::$app->db->createCommand($sql)->execute();
            }
        }

        if (empty($likes)) {
            $model->likes = serialize([$currentUser->getId()]);
            $model->post_id = $idPost;
            $model->count1 = 1;
            $model->save();
            return 1;
        } else {
            $currentLikesArray = unserialize($likes->likes);
            if (!in_array($currentUser->getId(), $currentLikesArray)) {
                array_push($currentLikesArray, $currentUser->getId());
                $model->likes = serialize($currentLikesArray);
                $model->post_id = $idPost;
                $model->count1 = count($currentLikesArray);
                $sql = "UPDATE likes SET likes = '$model->likes', count1 = '$model->count1' WHERE post_id = '$model->post_id'";
                Yii::$app->db->createCommand($sql)->execute();
                return count($currentLikesArray);
            }
            return count($currentLikesArray);
        }
    }

    public function unlike(User $currentUser)
    {
        $userId = intval($currentUser->getId());
        $postId = intval($this->id);
        $likes = Likes::find()->where(['post_id' => $postId])->one();
        $like = $likes->likes;
        $user = User::findOne($userId);

        if (!empty($user)) {
            $array = unserialize($user->likes);
            if (in_array($postId, $array)) {
                foreach ($array as $key => $item) {
                    if ($item == $postId) {
                        unset($array[$key]);
                    }
                }
                $userLike = serialize($array);
                $sql = "UPDATE user SET likes = '$userLike' WHERE id = '$userId'";
                Yii::$app->db->createCommand($sql)->execute();
            }
        }

        if (!empty($like)) {
            $likesArray = unserialize($like);
            if (in_array($userId, $likesArray)) {
                foreach ($likesArray as $key => $item) {
                    if ($item == $userId) {
                        unset($likesArray[$key]);
                    }
                }
            }
            $likes->likes = serialize($likesArray);
            $likes->count1 = count($likesArray);
            $sql = "UPDATE likes SET likes = '$likes->likes', count1 = '$likes->count1' WHERE post_id = '$postId'";
            Yii::$app->db->createCommand($sql)->execute();

            return count($likesArray);
        }

        return [
            'userId' => $userId,
            'postId' => $postId,
        ];
    }

    public function countLikes()
    {
        $idPost = $this->id;
        $likes = Likes::find()->where(['post_id' => $idPost])->one();
        if (!empty($likes)) {
            return $likes->count1;
        }
        return 0;
    }

    public function isLikedBy(User $user)
    {
        $userId = $user->getId();
        $postId = $this->id;
        $likes = Likes::find()->where(['post_id' => $postId])->one();
        if (!empty($likes)) {
            if (in_array($userId, unserialize($likes->likes))) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function authorName($id)
    {
        return \frontend\models\User::findOne($id)->username;

    }

    public function authorPhoto($id)
    {
        return \frontend\models\User::findOne($id)->getPicture();
    }

    public function getPostLikes()
    {
        return $this->hasOne(Likes::class, ['post_id' => 'id']);
    }

    public static function getBestPosts()
    {
        $posts = Post::find()
            ->select('post.*')
            ->leftJoin('likes', '`likes`.`post_id` = `post`.`id`')
            ->where(['status' => 1])
            ->orderBy('count1 desc')
            ->limit(8)
            ->all();


//        $sql = "SELECT post.id, post.user_id, post.filename, post.created_at, post.status, post.description, likes.count1 FROM likes LEFT JOIN  post ON likes.post_id = post.id WHERE status = 1 ORDER BY count1 DESC LIMIT 8";
//        return Yii::$app->db->createCommand($sql)->queryAll();
        return $posts;


    }

    public function getCountComments()
    {
        $postId = $this->id;
        $count = Comment::find()->where(['post_id' => $postId])->count();
        return $count;
    }

    public function complain(User $user)
    {
        $userId = $user->getId();
        $array = unserialize($this->complaints);

        if (empty($array)) {
            $complain = serialize([$userId]);
            $count = 1;
        } else {
            if (!in_array($userId, $array)) {
                array_push($array, $userId);
                $complain = serialize($array);
                $count = count($array);
            } else {
                return true;
            }
        }

        $this->complaints = $complain;
        $this->complaints_count = $count;
        if ($this->save(false, ['complaints', 'complaints_count'])) {
            return true;
        }

    }

    public function isReported(User $user)
    {
        $userId = $user->getId();
        $array = unserialize($this->complaints);
        if (!empty($array)) {
            if (in_array($userId, $array)) {
                return true;
            }
            return false;
        }
        return false;
    }

    public static function getForFriends($pageSize, $userId)
    {
        $query = Post::find()
            ->where(['user_id' => $userId])
            ->andWhere(['status' => [
                1, 2,
            ]])
            ->orderBy('id desc');

        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $posts = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $data['posts'] = $posts;
        $data['pagination'] = $pagination;
        return $data;
    }

    public static function getAll($pageSize, $userId)
    {
        $query = Post::find()
            ->where(['user_id' => $userId])
            ->andWhere(['status' => [
                1,
            ]])
            ->orderBy('id desc');

        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $posts = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $data['posts'] = $posts;
        $data['pagination'] = $pagination;
        return $data;
    }

    public static function getMyPosts($pageSize,$userId)
    {
        $query = Post::find()
            ->where(['user_id' => $userId])
            ->andWhere('status < 4')
            ->orderBy('id desc');
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $posts = $query->offset($pagination->offset)
        ->limit($pagination->limit)
        ->all();
        $data['posts'] = $posts;
        $data['pagination'] = $pagination;
        return $data;
    }


}



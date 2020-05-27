<?php

namespace frontend\models;

use app\models\Subscriptions;
use app\models\Followers;
use frontend\models\Post;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;


/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $about
 * @property integer $type
 * @property string $nickname
 * @property string $picture
 * @property string $likes
 * @property string $rating
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    const DEFAULT_IMAGE = '/img/profile_default_image.jpg';


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getNickname()
    {
        return ($this->nickname) ? $this->nickname : $this->getId();
    }


    public static function addSubscribe($userId)
    {
        $subscribe = new Subscriptions();
        $subscribe->user_id = $userId;
        $subscribe->subscribe = serialize([$userId]);
        $subscribe->save();

        $follower = new Followers();
        $follower->user_id = $userId;
        $follower->followers = serialize([$userId]);
        $follower->save();
    }

    public function followUser(User $user)
    {
//        $redis = Yii::$app->redis;
//        $redis->sadd("user:{$this->getId()}:subscriptions", $user->getId());
//        $redis->sadd("user:{$user->getId()}:followers", $this->getId());

        $model = new Subscriptions();
        $currentUserId = intval($this->getId());
        $user = intval($user->getId());


        $subscr = $model->find()->where(['user_id' => $currentUserId])->one();

        if ($subscr == null) {
            $model->user_id = $currentUserId;
            $model->subscribe = serialize([$user]);
            $model->save();

        } else {
            $massiv = unserialize($subscr->subscribe);
            if (!in_array($user, $massiv)) {
                array_push($massiv, $user);

                $model->id = $subscr->id;
                $model->user_id = $currentUserId;
                $model->subscribe = serialize($massiv);
                $sql = "UPDATE subscriptions2 SET subscribe = '$model->subscribe' WHERE id = '$model->id'";
                Yii::$app->db->createCommand($sql)->execute();
            }
        }

        $folow = new Followers();
        $userFollow = $folow->find()->where(['user_id' => $user])->one();
        if ($userFollow == null) {
            $folow->user_id = $user;
            $folow->followers = serialize([$currentUserId]);
            $folow->save();
        } else {

            $array = unserialize($userFollow->followers);

            if (!in_array($currentUserId, $array)) {
                array_push($array, $currentUserId);
                $newArray = serialize($array);
                $sql = "UPDATE followers SET followers = '$newArray' WHERE id = '$userFollow->id'";
                Yii::$app->db->createCommand($sql)->execute();
                return true;
            }
            return true;
        }
        return true;
    }

    public function unfollowUser(User $user)
    {
//        $redis = Yii::$app->redis;
//        $redis->srem("user:{$this->getId()}:subscriptions", $user->getId());
//        $redis->srem("user:{$user->getId()}:followers", $this->getId());

        $modelSubscriber = new Subscriptions();
        $currentUserId = intval($this->getId());
        $user = intval($user->getId());

        $currentSubscrib = $modelSubscriber->find()->where(['user_id' => $currentUserId])->one();
        $subscribArray = unserialize($currentSubscrib->subscribe);

        if (in_array($user, $subscribArray)) {
            foreach ($subscribArray as $key => $item) {
                if ($item == $user) {
                    unset($subscribArray[$key]);
                }
            }
            $newArray = serialize($subscribArray);

            $sql = "UPDATE subscriptions2 SET subscribe = '$newArray' WHERE id = '$currentSubscrib->id'";
            Yii::$app->db->createCommand($sql)->execute();
        }

        $modelFollowers = new Followers();
        $userFollow = $modelFollowers->find()->where(['user_id' => $user])->one();
        $followCurrentArray = unserialize($userFollow->followers);
        if (in_array($currentUserId, $followCurrentArray)) {
            foreach ($followCurrentArray as $key => $item) {
                if ($item == $currentUserId) {
                    unset($followCurrentArray[$key]);
                }
            }
            if ($followCurrentArray == null) {
                $sql2 = "DELETE FROM followers WHERE id = '$userFollow->id'";
                Yii::$app->db->createCommand($sql2)->execute();
                return true;
            } else {
                $newArray2 = serialize($followCurrentArray);
                $sql3 = "UPDATE followers SET followers = '$newArray2' WHERE id = '$userFollow->id'";
                Yii::$app->db->createCommand($sql3)->execute();
                return true;
            }

        }
        return true;
    }

    public function getSubscriptions()
    {
        $subscriber = new Subscriptions();
        if ($subscr = $subscriber->find()->where(['user_id' => $this->getId()])->one()) {
            $arrayDown = $subscr->subscribe;
            $array = unserialize($arrayDown);
        } else {
            $array = false;
        }

        $ids = $array;
        return User::find()->select('id, username, nickname')->where(['id' => $ids])->orderBy('username')->asArray()->all();

    }


    public function getSubscriptionsPosts($limit)
    {
        $oneUserPostsLimit = 10;
        if ($subscr = Subscriptions::find()->where(['user_id' => $this->getId()])->one()) {
            $arrayDown = $subscr->subscribe;
            $array = unserialize($arrayDown);
        } else {
            $array = false;
        }
        $ids = $array;
        $postArray = [];
        foreach($ids as $key => $id){
            $userSubscr = Subscriptions::find()->where(['user_id' => $id])->one();
            if (!empty($userSubscr->subscribe)) {
                $arraySubscribe = unserialize($userSubscr->subscribe);
                if (in_array($this->getId(), $arraySubscribe)){
                    $posts = Post::find()->where(['user_id'=>$id])->andWhere(['status'=>[1,2]])
                        ->orderBy('created_at desc')->limit($oneUserPostsLimit)->all();
                    foreach ($posts as $post){
                        array_push($postArray,$post);
                    }
                } else {
                    $posts = Post::find()->where(['user_id'=>$id])->andWhere(['status'=>[1]])
                        ->orderBy('created_at desc')->limit($oneUserPostsLimit)->all();
                    foreach ($posts as $post){
                        array_push($postArray,$post);
                    }
                }
            }
        }

        //Сортировка объектов в массиве, по оределенному свойству
        usort($postArray, array($this, "cmp"));

        $postArray = array_slice($postArray, 0, 500);

//        dumper($postArray);die;
        return $postArray;

    }

    public function cmp($a, $b)
    {
        return strcmp($b->created_at, $a->created_at);
    }


    public function getFollowers()
    {
//        $redis = Yii::$app->redis;
//        $key = "user:{$this->getId()}:followers";
//        return $redis->smembers($key);
        $followers = new Followers();
        if ($foll = $followers->find()->where(['user_id' => $this->getId()])->one()) {
            $array = unserialize($foll->followers);
        } else {
            $array = false;
        }
        $ids = $array;
        return User::find()->select('id, username, nickname')->where(['id' => $ids])->orderBy('username')->asArray()->all();
    }


    public function countFollowers()
    {
        $followers = Followers::find()->where(['user_id' => $this->getId()])->one();
        if ($followers) {
            $count = count(unserialize($followers->followers));
            if ($count != null) {
                return $count;
            }
        }
        return 0;
    }

    public function countSubscribers()
    {
        $subscribers = Subscriptions::find()->where(['user_id' => $this->getId()])->one();

        if ($subscribers) {
            $count = count(unserialize($subscribers->subscribe));
            if ($count != null) {
                return $count;
            }
        }
        return 0;
    }

    public function getMutualSubscriptionsTo($user)
    {
        $currentUserId = $this->getId();
        $userId = $user->id;
        $currentUserSubscribrs = Subscriptions::find()->where(['user_id' => $currentUserId])->one();
        $userFollows = Followers::find()->where(['user_id' => $userId])->one();


        if ($currentUserSubscribrs !=null && $userFollows != null){
            $key1 = unserialize($currentUserSubscribrs->subscribe);
            $key2 = unserialize($userFollows->followers);
            $intersect = array_intersect($key1, $key2);
            return self::find()->select('id,username,nickname')->where(['id' => $intersect])->orderBy('username')->asArray()->all();
        }
        return null;
    }

    public function isFollowers($user)
    {
        $currentUserId = $this->getId();
        $userId = $user->id;
        $userFollows = Followers::find()->where(['user_id' => $userId])->one();
        if ($userFollows) {
            $asArray = unserialize($userFollows->followers);
            if($userFollows){
                if (in_array($currentUserId, $asArray)){
                    return true;
                }
                return false;
            }
            return false;
        }
        return false;
    }

    public function isFollowersId($userId)
    {
        $currentUserId = $this->getId();
        $userFollows = Followers::find()->where(['user_id' => $userId])->one();

        if ($userFollows) {
            $asArray = unserialize($userFollows->followers);
            if($userFollows){
                if (in_array($currentUserId, $asArray)){
                    return true;
                }
                return false;
            }
            return false;
        }
        return false;
    }

    public function isUserYourSubscriber($user){
        $youId = $this->getId();
        $userId = $user->id;
        $userSubscribe = Subscriptions::find()->where(['user_id' => $userId])->one();
        if ($userSubscribe) {
            $asArray = unserialize($userSubscribe->subscribe);
            if (in_array($youId, $asArray)){
                return true;
            }
            return false;
        }
        return false;
    }


    public function countMutualFriends($user)
    {
        $currentUserId = $this->getId();
        $userId = $user->id;
        $currentUserSubscribrs = Subscriptions::find()->where(['user_id' => $currentUserId])->one();
        $userFollows = Followers::find()->where(['user_id' => $userId])->one();


        if ($currentUserSubscribrs !=null && $userFollows != null){
            $key1 = unserialize($currentUserSubscribrs->subscribe);
            $key2 = unserialize($userFollows->followers);
            $intersect = array_intersect($key1, $key2);
            return count($intersect);
        }
        return null;
    }

    public function getPicture()
    {
        if($this->picture) {
            return Yii::$app->storage->getFile($this->picture);
        }
        return self::DEFAULT_IMAGE;
    }


    public static function getUserPhoto2($id)
    {
        $user = User::findOne($id);
        $filename = $user->picture;
        if($filename) {
            return Yii::$app->storage->getFile($filename);
        }
        return self::DEFAULT_IMAGE;
    }


    public function getFeed($limit)
    {
        $order = ['post_created_at' => SORT_DESC];
        return $this->hasMany(Feed::class, ['user_id' => 'id'])->orderBy($order)->limit($limit)->all();
    }

    public function isLikedBy(User $user)
    {
        $userId = $user->getId();
        $postId = $this->id;
        $likes = Likes::find()->where(['post_id' => $postId])->one();
        if (!empty($likes)){
            if (in_array($userId, unserialize($likes->likes)))
            {
                return true;
            }
            return false;
        }
        return false;
    }

    public function likesPost($postId)
    {
        $userId = $this->getId();

        $likes = Likes::find()->where(['post_id' => $postId])->one();
        if (!empty($likes)){
            if (in_array($userId, unserialize($likes->likes)))
            {
                return true;
            }
            return false;
        }
        return false;
    }

    public static function getUserName($id)
    {
        $user = User::findOne($id);
        return $user->username;
    }

    public static function getUserPhoto($id)
    {
        $user = User::findOne($id);
        return $user->picture;
    }


}























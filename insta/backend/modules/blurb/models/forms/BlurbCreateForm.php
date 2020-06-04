<?php


namespace backend\modules\blurb\models\forms;


use backend\modules\blurb\models\Blurb;
use yii\base\Model;

class BlurbCreateForm extends Model
{
    public $id;
    public $title;
    public $customer;
    public $text;
    public $url;
    public $description;
    public $status;
    public $insert;

    public $sort;

    public function rules()
    {
        return [
            [['title', 'customer', 'description', 'insert'], 'string'],
            [['title', 'customer', 'description', 'text', 'insert','url'], 'required'],
            [['status', 'id', 'sort'], 'integer'],
        ];
    }

    public function save()
    {
        if ($this->validate()) {
            $blurb = new Blurb();
            $blurb->title = $this->title;
            $blurb->customer = $this->customer;
            $blurb->text = $this->text;
            $blurb->url = $this->url;
            $blurb->description = $this->description;
            $blurb->status = 3;
            $blurb->sort = $this->sort;
            $blurb->insert = $this->insert;

            if($blurb->save()) {
                return true;
            }
            return false;
        }
        return false;
    }


}





















<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string|null $address
 * @property string $telephone_number
 * @property string $reg_date
 * @property int|null $is_regular_user
 * @property int|null $is_librarian
 * @property int|null $is_admin
 * @property string $auth_key
 * @property string $access_token
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{

    public $old_password;
    public $new_password;
    public $repeat_new_password;
    public $book_id;
    public $amount;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'password', 'telephone_number', 'auth_key', 'access_token'], 'required'],
            [['reg_date', 'new_password', 'old_password', 'book_id', 'amount'], 'safe'],
            [['is_regular_user', 'is_librarian', 'is_admin'], 'integer'],
            [['first_name', 'last_name'], 'string', 'max' => 16],
            [['email', 'telephone_number'], 'string', 'max' => 32],
            [['password', 'auth_key', 'access_token'], 'string', 'max' => 255],
            [['address'], 'string', 'max' => 128],
            [['email'], 'unique'],

            [['new_password', 'repeat_new_password'], 'string', 'min' => 8],
            ['repeat_new_password', 'compare', 'compareAttribute' => 'new_password'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'password' => 'Password',
            'address' => 'Address',
            'telephone_number' => 'Telephone Number',
            'reg_date' => 'Reg Date',
            'is_regular_user' => 'Is Regular User',
            'is_librarian' => 'Is Librarian',
            'is_admin' => 'Is Admin',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        // find the user by id
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::find()->where(['access_token' => $token])->one();
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return self::findOne(['email' => $email]);
    }

    public function isAdmin() {
        return $this->is_admin;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
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
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function isAdminOrLibrarian() {
        return $this->is_librarian or $this->is_admin;
    }

    /**
     * Gets query for [[BookedBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookedBooks()
    {
        return $this->hasMany(BookedBooks::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[TakenBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
//    public function getTakenBooks()
//    {
//        return $this->hasMany(TakenBooks::class, ['user_id' => 'id']);
//    }

}

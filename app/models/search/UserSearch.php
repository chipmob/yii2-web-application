<?php

namespace app\models\search;

use common\components\helpers\Date;
use kartik\daterange\DateRangeBehavior;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class UserSearch extends \chipmob\user\models\search\UserSearch
{
    const ROLE_NULL = '_null_';

    public ?string $role = null;

    public ?string $created_at_range = null;
    public ?int $created_at_from = null;
    public ?int $created_at_to = null;

    public ?string $action_at_range = null;
    public ?int $action_at_from = null;
    public ?int $action_at_to = null;

    public ?string $is_online = null;

    /** @inheritdoc */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['role'], 'string'],
            [['is_online'], 'integer', 'min' => 0, 'max' => 1],
            [['created_at_range', 'action_at_range'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
        ]);
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => DateRangeBehavior::class,
                'attribute' => 'created_at_range',
                'dateStartAttribute' => 'created_at_from',
                'dateEndAttribute' => 'created_at_to',
            ],
            [
                'class' => DateRangeBehavior::class,
                'attribute' => 'action_at_range',
                'dateStartAttribute' => 'action_at_from',
                'dateEndAttribute' => 'action_at_to',
            ],
        ]);
    }

    public function search(array $params): ActiveDataProvider
    {
        $dataProvider = parent::search($params);

        /** @var ActiveQuery $query */
        $query = $dataProvider->query;

        if ($this->role == self::ROLE_NULL) {
            $query->leftJoin('auth_assignment', 'user.id = auth_assignment.user_id');
            $query->andWhere(['auth_assignment.user_id' => null]);
        } else {
            $query->andFilterWhere(['user.id' => Yii::$app->authManager->getUserIdsByRole($this->role)]);
        }

        switch ($this->is_online) {
            case '0':
                $query->andWhere(['not in', 'user.id', array_keys(Yii::$app->session->onlineUsers)]);
                break;
            case '1':
                $query->andWhere(['in', 'user.id', array_keys(Yii::$app->session->onlineUsers)]);
                break;
        }

        Date::setTomorrowStart($this->created_at_to);
        $query->andFilterWhere(['>=', 'user.created_at', $this->created_at_from])->andFilterWhere(['<', 'user.created_at', $this->created_at_to]);

        Date::setTomorrowStart($this->action_at_to);
        $query->andFilterWhere(['>=', 'user.action_at', $this->action_at_from])->andFilterWhere(['<', 'user.action_at', $this->action_at_to]);

        $dataProvider->query = $query;

        return $dataProvider;
    }
}

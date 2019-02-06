<?php

namespace App\Models\Globals;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Masters\Item;
use App\Models\Masters\ItemProperty;

/**
 * ユーザーが持つアイテムを表すモデル。
 *
 * ユーザーが保持するアイテムや装備品、素材などが格納される。
 * ユーザーは重量の限界までアイテムを持つことができる。
 * アイテムは、特別なデータを持たないスタッカブル品と、
 * 個別に管理されるジェネレーテッド品がある。
 */
class UserItem extends Model
{
    /**
     * 複数代入する属性。
     * @var array
     */
    protected $fillable = [
        'user_id',
        'item_id',
        'count',
        'property_ids',
    ];

    /**
     * ネイティブなタイプへキャストする属性。
     * @var array
     */
    protected $casts = [
        'property_ids' => 'array',
    ];

    /**
     * 属性に設定するデフォルト値。
     * @var array
     */
    protected $attributes = [
        'property_ids' => '[]',
    ];

    /**
     * ユーザーとのリレーション定義。
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo('App\Models\Globals\User');
    }

    /**
     * オブジェクト種別からアイテムなどを加算する。
     * @param int $userId ユーザーID。
     * @param array $data {type,object_id,count} 形式の情報。
     * @return UserItem 加算されたオブジェクト。対象外の種別の場合はnull。
     */
    public static function addObjectByType(int $userId, array $data) : ?UserItem
    {
        switch ($data['type']) {
            case 'item':
                $item = Item::findOrFail($data['object_id']);
                return self::addItem($userId, $item, $data['count']);
        }
        return null;
    }

    /**
     * アイテムを加算する。
     * @param int $userId ユーザーID。
     * @param Item $item アイテムマスタ。
     * @param int $count 加算する個数。
     * @return UserItem 加算されたオブジェクト。
     */
    private static function addItem(int $userId, Item $item, int $count) : ?UserItem
    {
        // TODO: 高レアアイテムは受け取った瞬間にランダムで称号が付く
        // TODO: ジェネレータブルアイテムの対応
        // TODO: アイテムが持てるかの重量チェックとかする
        $userItem = self::lockForUpdate()->where([
            'user_id' => $userId,
            'item_id' => $item->id,
        ])->first();
        if ($userItem) {
            $userItem->count += $count;
            $userItem->save();
            return $userItem;
        }
        return self::create([
            'user_id' => $userId,
            'item_id' => $item->id,
            'count' => $count,
        ]);
    }
}
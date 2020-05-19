<template>
    <div id="event-edit">
    </div>
</template>

<script>
/**
 * [イベント編集] - イベント情報の更新と写真の追加・削除が可能
 * * 必要な情報
 *  * 単一のイベント情報
 *   * created内でstoreにあるeventsからルートパラメータのイベントを取得
 *   * 更新時に参照するため、eventに格納
 *  * イベントに紐づく写真情報
 *   * イベントのリレーションから取得
 *   * 削除時に参照するため、photosに格納
 */
export default {
    name: 'EventEdit',
}
</script>

<style scoped>
</style>

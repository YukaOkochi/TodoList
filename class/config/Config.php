<?php
class Config {
    const DB_NAME = 'shared_todo_lists';
    const DB_HOST = 'localhost';
    const DB_USER = 'root';
    const DB_PASS = '';


    const RANDOM_PSEUDO_STRING_LENGTH = 32;
    const MSG_INVALID_PROCESS = '不正な処理が行われました。';
    const MSG_USER_LOGIN_FAILURE = 'ユーザー名またはパスワードが違います。';
    const MSG_SELECT_ITEM = '項目名を入力してください。';
    const MSG_OVER_ITEM = '項目名は100文字以下にしてください。';
    const MSG_SELECT_NAME = '担当者を選択してください。';
    const MSG_PROPER_NAME = '適切な担当者を選択してください。';
    const MSG_SELECT_CATEGORY = 'カテゴリーを選択してください。';
    const MSG_PROPER_CATEGORY = '適切なカテゴリーを選択してください。';
    const MSG_MISTAKEN_DATE = '期限日の日付が正しくありません。';
    const MSG_WRITE_CATEGORY = 'カテゴリー名を入力してください。';
    const MSG_OVER_CATEGORY = 'カテゴリー名は50文字以下にしてください。';
    const MSG_EXCEPTION = '申し訳ございません。エラーが発生しました。';
}
?>
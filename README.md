# TodoList
複数の人で共有して使えるTodoListです。カテゴリーごとに整理することができ、見やすく使用することができます。

PHPの勉強のために作りました。セキュリティを意識したPHPでのデータベース操作や基本の画面設計、SESSIONを用いたバリデーション機能の実装ができるようになりました。

https://user-images.githubusercontent.com/131846010/234779645-785a09c9-8b87-429f-b34f-aedc2d1d9750.mp4


## 工夫したポイント
+ 期限日を過ぎたら文字が赤くなる
+ 完了ボタンを押すと完了日が入力され打ち消し線が出る
+ カテゴリーを削除すると中の登録情報も一緒に削除できる
+ 新規登録をすると自動で登録日が入力される
+ 登録、更新画面で入力情報に誤りがあるとエラーメッセージが表示される

## 機能
+ ログイン・ログアウト機能
+ カテゴリー別分類機能
+ 作業情報登録・削除・更新・検索機能

## 実装環境
バックエンド　： PHP(8.2.4) , MySQL

フロントエンド： HTML , CSS(Bootstrap5)

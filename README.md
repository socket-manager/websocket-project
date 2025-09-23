# WEBSOCKET-PROJECT — WebSocketサーバー開発環境
WEBSOCKET-PROJECT は SOCKET-MANAGER フレームワーク用の軽量な WebSocket サーバー開発テンプレートです。
PHP で動作する WebSocket サーバーの起動・検証用クライアントを含み、Laravel との連携も可能です。

## 概要
- プロトコル実装済みなので、コマンド（ビジネスロジック）処理を追加するだけですぐに使えます。
- 開発用の軽量クライアント（/app/client/test.html）で動作検証が可能です。
- Laravel と連携できます（ドキュメントあり）。

## 特長
- すぐに使える WebSocket サーバー実装（プロトコル対応済み）
- 最小限のテスト用クライアントを同梱（ブラウザで簡単に動作確認）
- Laravel とシームレスに連携可能

## クイックスタート（Quick Start）
1. プロジェクトルートで以下のコマンドを実行して WebSocket サーバーを起動します。

```bash
php worker app:websocket-server [<ポート番号>]
```

- ポート番号を省略するとデフォルトポートが使用されます。
- 例: `php worker app:websocket-server 8080`

2. サーバーが起動したら、同梱のテストクライアントで接続を確認します（次節参照）。

## クライアントでの動作検証
- 検証用の最小限の HTML クライアントは次のパスにあります（ブラウザにドラッグ＆ドロップして開くだけで動作します。Web サーバーを起動する必要はありません）。

```code
/app/client/test.html
```

- テストクライアントは簡易的な送受信ロジックのみ含むため、実運用では独自クライアント実装を推奨します。

## Laravel との連携
このプロジェクトは Laravel と連携して使えます。具体的な連携方法や設定手順は以下のドキュメントをご参照ください。

https://socket-manager.github.io/document/laravel.html

## ドキュメント
より詳しい使い方や設計方針は以下の公式ドキュメントに記載しています。

https://socket-manager.github.io/document/websocket.html

## Contact Us
バグ報告やご要望などは<a href="mailto:lib.tech.engineer@gmail.com">`こちら`</a>から受け付けております。

## License
MIT, see <a href="https://github.com/socket-manager/websocket-project/blob/main/LICENSE">LICENSE file</a>.
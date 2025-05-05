# WEBSOCKET-PROJECT on SOCKET-MANAGER Framework
Websocketサーバーの開発環境です。<br />
プロトコルは実装済みなのでコマンド処理を追加するだけで使えます。

## サーバーの起動
プロジェクトルートディレクトリで以下のコマンドを実行すればサーバーを起動できます。

<pre>
> php worker app:websocket-server [<ポート番号>]
</pre>

## クライアントの起動
以下のディレクトリにHTMLファイルが入っています（検証用なので最小限のロジックしか入っていません）。<br />
そのファイルをブラウザにドラッグ＆ドロップしてください（Webサーバーを起動する必要はありません）。

/app/client/test.html

## 補足
プロジェクトの詳しい使い方は<a href="https://socket-manager.github.io/document/websocket.html">こちら</a>をご覧ください。

このプロジェクトはLaravelと連携できます。<br />
詳しい連携方法は<a href="https://socket-manager.github.io/document/laravel.html">こちら</a>をご覧ください。

## Contact Us
バグ報告やご要望などは<a href="mailto:lib.tech.engineer@gmail.com">`こちら`</a>から受け付けております。

## License
MIT, see <a href="https://github.com/socket-manager/websocket-project/blob/main/LICENSE">LICENSE file</a>.
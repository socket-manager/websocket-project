<?php
/**
 * メイン処理クラスのファイル
 * 
 * SocketManagerの実行
 */

namespace App\MainClass;

use SocketManager\Library\SocketManager;
use SocketManager\Library\FrameWork\Console;

use App\InitClass\InitForWebsocketClient;
use App\ProtocolUnits\ProtocolForWebsocketClient;
use App\UnitParameter\ParameterForWebsocketClient;


/**
 * メイン処理クラス
 * 
 * SocketManagerの初期化と実行
 */
class MainForWebsocketClient extends Console
{
    /**
     * @var string $identifer サーバー識別子
     */
    protected string $identifer = 'app:websocket-client {port_no?}';

    /**
     * @var string $description コマンド説明
     */
    protected string $description = 'Websocketクライアント';

    /**
     * @var string $host ホスト名（接続用）
     */
    private string $host = 'localhost';

    /**
     * @var int $port ポート番号（接続用）
     */
    private int $port = 10000;

    /**
     * @var int $cycle_interval 周期インターバル時間（μs）
     */
    private int $cycle_interval = 1000;

    /**
     * @var int $alive_interval アライブチェックタイムアウト時間（s）
     */
    private int $alive_interval = 3600;


    /**
     * サーバー起動
     * 
     */
    public function exec()
    {
        //--------------------------------------------------------------------------
        // 設定値の反映
        //--------------------------------------------------------------------------

        // ホスト名の設定
        $this->host = config('const.host', $this->host);

        // ポート番号の設定
        $this->port = config('const.port', $this->port);

        // 周期インターバルの設定
        $this->cycle_interval = config('const.cycle_interval', $this->cycle_interval);

        // アライブチェックタイムアウト時間の設定
        $this->alive_interval = config('const.alive_interval', $this->alive_interval);

        //--------------------------------------------------------------------------
        // 引数の反映
        //--------------------------------------------------------------------------

        // 引数の取得
        $port = $this->getParameter('port_no');
        if($port !== null)
        {
            $this->port = $port;
        }

        //--------------------------------------------------------------------------
        // SocketManagerの初期化
        //--------------------------------------------------------------------------

        // ソケットマネージャーのインスタンス設定
        $manager = new SocketManager();

        // UNITパラメータインスタンスの設定
        $param = new ParameterForWebsocketClient();

        // SocketManagerの設定値初期設定
        $init = new InitForWebsocketClient($param, $this->port);
        $manager->setInitSocketManager($init);

        // プロトコルUNITの設定
        $entry = new ProtocolForWebsocketClient();
        $manager->setProtocolUnits($entry);

        //--------------------------------------------------------------------------
        // 接続開始
        //--------------------------------------------------------------------------

        $ret = $manager->connect($this->host, $this->port);
        if($ret === false)
        {
            goto finish;   // リッスン失敗
        }

        //--------------------------------------------------------------------------
        // ノンブロッキングループ
        //--------------------------------------------------------------------------

        while(true)
        {
            // 周期ドリブン
            $ret = $manager->cycleDriven($this->cycle_interval, $this->alive_interval);
            if($ret === false)
            {
                goto finish;
            }
        }

finish:
        // 全接続クローズ
        $manager->shutdownAll();
    }
}

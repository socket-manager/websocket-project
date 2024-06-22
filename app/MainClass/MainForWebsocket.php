<?php
/**
 * メイン処理クラスのファイル
 * 
 * Websocketプロトコル対応
 */

namespace App\MainClass;


use SocketManager\Library\SocketManager;
use SocketManager\Library\FrameWork\Console;

use App\UnitParameter\ParameterForWebsocket;
use App\InitClass\InitForWebsocket;
use App\ProtocolUnits\ProtocolForWebsocket;
use App\CommandUnits\CommandForWebsocket;


/**
 * メイン処理クラス
 * 
 * Websocketプロトコル対応
 */
class MainForWebsocket extends Console
{
    //--------------------------------------------------------------------------
    // 定数
    //--------------------------------------------------------------------------


    //--------------------------------------------------------------------------
    // プロパティ
    //--------------------------------------------------------------------------

    /**
     * @var string コマンド処理の識別子
     */
    protected string $identifer = 'app:websocket-server {port_no?}';

    /**
     * @var string コマンド説明
     */
    protected string $description = 'Websocketサーバー';

    /**
     * @var string $host ホスト名（リッスン用）
     */
    private string $host = 'localhost';

    /**
     * @var int $port ポート番号（リッスン用）
     */
    private int $port = 10000;

    /**
     * @var int $cycle_interval 周期インターバル時間（μs）
     */
    private int $cycle_interval = 1000;

    /**
     * @var int $alive_interval アライブチェックタイムアウト時間（μs）
     */
    private int $alive_interval = 3600;


    //--------------------------------------------------------------------------
    // メソッド
    //--------------------------------------------------------------------------

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
        $this->host = config('const.host');

        // ポート番号の設定
        $this->port = config('const.port');

        // 周期インターバルの設定
        $this->cycle_interval = config('const.cycle_interval');

        // アライブチェックタイムアウト時間の設定
        $this->alive_interval = config('const.alive_interval');

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
        $manager = new SocketManager($this->host, $this->port);

        // UNITパラメータインスタンスの設定
        $param = new ParameterForWebsocket();

        // SocketManagerの設定値初期設定
        $init = new InitForWebsocket($param, $this->port);
        $manager->setInitSocketManager($init);

        // プロトコルUNITの設定
        $entry = new ProtocolForWebsocket();
        $manager->setProtocolUnits($entry);

        // コマンドUNITの設定
        $entry = new CommandForWebsocket();
        $manager->setCommandUnits($entry);

        //--------------------------------------------------------------------------
        // リッスンポートで待ち受ける
        //--------------------------------------------------------------------------

        $ret = $manager->listen();
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

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
     * ホスト名（リッスン用）
     */
    private ?string $host = 'localhost';

    /**
     * 周期インターバル時間（μs）
     */
    private int $cycle_interval = 1000;

    /**
     * アライブチェックタイムアウト時間（μs）
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
        // 引数の取得
        $port_no = $this->getParameter('port_no');

        //--------------------------------------------------------------------------
        // 初期化
        //--------------------------------------------------------------------------

        // ソケットマネージャーのインスタンス設定
        $manager = new SocketManager($this->host, $port_no);

        // UNITパラメータインスタンスの設定
        $param = new ParameterForWebsocket();

        // SocketManagerの設定値初期設定
        $init = new InitForWebsocket($param, $port_no);
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

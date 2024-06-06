$(function()
{
    /**
     * Websocketのインスタンス
     */
    let websocket = null;


    // 接続ボタン
    $(document).on('click', '#connect_button', function()
    {
        if(websocket === null)
        {
            // ボタン名変更
            $('#connect_button').text('切断');

            // URI入力を禁止
            $('input[name="uri"]').prop('disabled', true);

            // Websocketを開く
            setOpenWebsocket();
        }
        else
        {
            websocket.close();
        }
    });


    /**
     * Websocketイベントの定義
     */
    function setOpenWebsocket()
    {
        let uri = $('input[name="uri"]').val();

        // Websocket接続
        websocket = new WebSocket(uri);

        /**
         * 接続完了イベント
         * 
         * @param {*} event イベントインスタンス
         * @returns 
         */
        websocket.onopen = function(event)
        {
        };
    
        /**
         * データ受信イベント
         * 
         * @param {*} event イベントインスタンス
         * @returns 
         */
        websocket.onmessage = function(event)
        {
            let data = JSON.parse(event.data);

            console.dir(data);
        };

        /**
         * 切断検知のイベント
         * 
         * @param {*} event イベントインスタンス
         * @returns 
         */
        websocket.onclose = function(event)
        {
            console.log(`Websocket切断情報[code=${event.code} reason=${event.reason}]`);

            // ボタン名変更
            $('#connect_button').text('接続');

            // URI入力を許可
            $('input[name="uri"]').prop('disabled', false);

            websocket = null;
        };
    
        /**
         * エラー検知のイベント
         * 
         * @param {*} error エラーインスタンス
         */
        websocket.onerror = function(error)
        {
            let error_message = '';
            if(typeof(error.message) !== 'undefined')
            {
                error_message = error.message;
            }
            console.log(`エラー発生[${error_message}]`);

            // Websocketを閉じる
            if(websocket !== null)
            {
                websocket.close();
            }

            websocket = null;
        };
    }
});

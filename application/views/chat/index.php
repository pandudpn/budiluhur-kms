<?php
$this->load->view('templates/header');
$this->load->view('templates/navbar');
$this->load->view('templates/sidebar');
?>

<div class="content-wrapper" id="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Chat</h4>
            <div id="body">
                <p>Silahkan pilih teman:</p>
                <table class="table" id="table-friend">
                    <?php foreach ($teman->result() as $item) { ?>
                    <tr>
                        <td><a href="javascript:;" data-friend="<?= $item->id_user ?>"><?= $item->nama ?></a></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
            <!-- TEMPLATE -->
            <div id="wgt-container-template" style="display: none">
                <div class="msg-wgt-container">
                    <div class="msg-wgt-header">
                        <a href="javascript:;" class="online"></a>
                        <a href="javascript:;" class="name"></a>
                        <a href="javascript:;" class="close">x</a>
                    </div>
                    <div class="msg-wgt-message-container">
                        <table width="100%" class="msg-wgt-message-list">
                        </table>
                    </div>
                    <div class="msg-wgt-message-form">
                        <textarea name="message" placeholder="Type your message. Press Shift + Enter for newline"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/x-template" id="msg-template" style="display: none">
    <tbody>
        <tr class="msg-wgt-message-list-header">
            <td rowspan="2"><img src="<?= base_url('assets/images/faces/'.$item->foto_user) ?>"></td>
            <td class="name"></td>
            <td class="time"></td>
        </tr>
        <tr class="msg-wgt-message-list-body">
            <td colspan="2"></td>
        </tr>
        <tr class="msg-wgt-message-list-separator"><td colspan="3"></td></tr>
    </tbody>
</script>

<script type="text/javascript">
$(document).ready(function($) {
    var chatPosition = [
        false, // 1
        false, // 2
        false, // 3
        false, // 4
        false, // 5
        false, // 6
        false, // 7
        false, // 8
        false, // 9
        false
    ];

    // New chat
    $(document).on('click', 'a[data-friend]', function(e) {
        var $data = $(this).data();
        if ($data.friend !== undefined && chatPosition.indexOf($data.friend) < 0) {
            var posRight = 0;
            var position;
            for(var i in chatPosition) {
                if (chatPosition[i] == false) {
                    posRight = (i * 270) + 20;
                    chatPosition[i] = $data.friend;
                    position = i;
                    break;
                }
            }
            var tpl = $('#wgt-container-template').html();
            var tplBody = $('<div/>').append(tpl);
            tplBody.find('.msg-wgt-container').addClass('msg-wgt-active');
            tplBody.find('.msg-wgt-container').css('right', posRight + 'px');
            tplBody.find('.msg-wgt-container').attr('data-chat-position', position);
            tplBody.find('.msg-wgt-container').attr('data-chat-with', $data.friend);
            $('body').append(tplBody.html());
            initializeChat();
        }
    });

    // Minimize Maximize
    $(document).on('click', '.msg-wgt-header > a.name', function() {
        var parent = $(this).parent().parent();
        if (parent.hasClass('minimize')) {
            parent.removeClass('minimize')
        } else {
            parent.addClass('minimize');
        }
    });

    // Close
    $(document).on('click', '.msg-wgt-header > a.close', function() {
        var parent = $(this).parent().parent();
        var $data = parent.data();
        parent.remove();
        chatPosition[$data.chatPosition] = false;
        setTimeout(function() {
            initializeChat();
        }, 1000)
    });

    var chatInterval = [];

    var initializeChat = function() {
        $.each(chatInterval, function(index, val) {
            clearInterval(chatInterval[index]);   
        });

        $('.msg-wgt-active').each(function(index, el) {
            var $data = $(this).data();
            var $that = $(this);
            var $container = $that.find('.msg-wgt-message-container');

            chatInterval.push(setInterval(function() {
                var oldscrollHeight = $container[0].scrollHeight;
                var oldLength = 0;
                $.get('<?= site_url('chat/getChats') ?>', {id_to: $data.id_to}, function(data, textStatus, xhr) {
                    $that.find('a.nama').text(data.name);
                    // from last
                    var chatLength = data.chats;
                    var newIndex = data.chats;
                    $.each(data.chats, function(index, el) {
                        newIndex--;
                        var val = data.chats[newIndex];

                        var tpl = $('#msg-template').html();
                        var tplBody = $('<div/>').append(tpl);
                        var id = (val.id_chat +'_'+ val.id_from +'_'+ val.id_to).toString();
                        


                        if ($that.find('#'+ id).length == 0) {
                            tplBody.find('tbody').attr('id', id);
                            tplBody.find('td.nama').text(val.name);
                            tplBody.find('td.time').text(val.ts_chat);
                            tplBody.find('.msg-wgt-message-list-body > td').html(nl2br(val.pesan));
                            $that.find('.msg-wgt-message-list').append(tplBody.html());

                            //Auto-scroll
                            var newscrollHeight = $container[0].scrollHeight - 20;
                            if (newIndex === 0) {
                                $container.animate({ scrollTop: newscrollHeight }, 'normal');
                            }
                        }
                    });
                });
            }, 1000));

            $that.find('textarea').on('keydown', function(e) {
                var $textArea = $(this);
                if (e.keyCode === 13 && e.shiftKey === false) {
                    $.post('<?= site_url('chat/sendMessage') ?>', {message: $textArea.val(), id_to: $data.friend}, function(data, textStatus, xhr) {
                    });
                    $textArea.val('');

                    e.preventDefault(); 
                    return false;
                }
            });
        });
    }

    var nl2br = function(str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }

    // on load
    initializeChat();
});
</script>

<?php
$this->load->view('templates/footer_1');
$this->load->view('templates/footer_2');
?>
    <div class="modal fade" id="ModalGue" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ModalHeader"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class='fa fa-times-circle'></i></button>
                </div>
                <div class="modal-body" id="ModalContent"></div>
                <div class="modal-footer" id="ModalFooter"></div>
            </div>
        </div>
    </div>
    <!-- chat -->
    <?php if($this->session->userdata('login')){ ?>
    <div id="chatbox_Chat" class="chatbox" style="bottom: 0px; right: 10px; display: block;">
        <div class="chatboxhead" onclick="javascript:toggleChatBoxGrowth('Chat')">
            <div class="chatboxtitle">Chat</div>
            <br clear="all">
        </div>
        <div id='kouta' class="chatboxcontent" style="display : none;">
            <div> <ul style="list-style-type: none; margin: 0; padding: 0;"><?php
                foreach ($session_data_user as $res) {
                    if ($this->session->userdata('username') != $res['username']) { 
                        ?>
                        <li>
                            <a style="line-height: 32px; cursor: pointer; text-decoration: none;" href="javascript:void(0)" onClick="javascript:chatWith('<?php echo $res['username']; ?>');" rel="ignore">
                                <div style="padding-left: 1px;position: relative;">
                                    <div style="float: left; height: 12px; position: relative;  width: 55px;">
                                        <?php
                                        foreach ($session_data_user as $row1):
                                            if($res['username'] === $row1['username']){ ?>
                                                <img id="image<?php echo $res['username']; ?>" src="<?php echo base_url('assets/images/faces/'.$row1['foto_user']); ?>" width="32" height="32" alt="" class="img">
                                    <?php   }
                                        endforeach;?>
                                    </div>
                                    <div style="overflow: hidden; padding-left: 8px; text-overflow: ellipsis; white-space: nowrap; padding-top: 6px;">
                                        <?php echo $res['username']; ?>

                                        <div style="float: right; margin: 0 1px 0 4px; text-align: right;">
                                            <div class="_568z">
                                                <span id="<?php echo $res['username']; ?>" style="background: <?php if ($res['is_online'] == 'online') echo 'rgb(66, 183, 42)';  else echo 'red'; ?>; border-radius: 50%;display: inline-block;height: 6px;margin-left: 4px;width: 6px;"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php }
                } // end foreach loop\
                ?></ul> </div> <?php
            }else{ echo "Nothing to load"; } // end if condition ?>
        </div>
    </div>
    <!-- .//chat -->
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/chat.js"></script>
</body>

</html>
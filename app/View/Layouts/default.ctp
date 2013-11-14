<?php
//include header
include_once 'header.ctp';
?>
            <div id="content">
                    <?php echo $this->Session->flash(); ?>
                <div class="container">
                    <div class="page">
                    <?php echo $this->fetch('content'); ?>
                    </div>
                </div>
            </div>
            <div id="footer">
            </div>
	</div>
</body>
</html>


<?php
include_once 'header.ctp';
?>
            <div id="content">

                    <?php echo $this->Session->flash(); ?>

                    <?php echo $this->fetch('content'); ?>
            </div>
            <div id="footer">
            </div>
	</div>
</body>
</html>

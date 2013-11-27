<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
                
                echo $this->Html->css(array('bootstrap-theme', 'bootstrap'));
                
                echo $this->Html->script(array(
                    'http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js',
                    'html5',
                    'bootstrap',
                    'http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min.js',
                    'http://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.1.0/backbone-min.js',
                    'backbone-helpers',
                    'ownscripts'
                    ));
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
<?php
//include templates for actual controller
    @include 'templates/'.$this->params['controller'].'.html';
?>
    <div id="container">
        <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
            <ul class="nav navbar-nav">
                <?php if($this->Session->read('Auth.User') != null)
                {
                    ?>
                    <li><?php echo $this->Html->link('Conferences', array('controller' => 'trainings', 'action' => 'viewall')); ?></li>
                    <li><?php echo $this->Html->link('Professions', array('controller' => 'professions', 'action' => 'viewall')); ?></li>
                    <li><?php echo $this->Html->link('Materials', array('controller' => 'materials', 'action' => 'viewall')); ?></li>
                    <li><?php echo $this->Html->link('Payment logs', array('controller' => 'payments', 'action' => 'viewall')); ?></li>
                    <li><a href="#">|</a></li>
                    <?php
                }
                ?>
                <li><?php echo $this->Html->link('Record for conference', array('controller' => 'records', 'action' => 'viewall')); ?></li>
                <li><?php echo $this->Html->link('Contact', array('controller' => 'homes', 'action' => 'contact')); ?></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if($this->Session->read('Auth.User') == null)
                    {
                        ?>
                        <li><?php echo $this->Html->link('Log in', array('controller' => 'auths', 'action' => 'login')); ?></li>
                        <?php
                    }
                    else
                    {
                        ?>
                        <li><?php echo $this->Html->link('Logout', array('controller' => 'auths', 'action' => 'logout')); ?></li>
                        <?php
                    }
                    ?>
            </ul>
        </nav>
<?php
/**
 * View/Elements/CircularNotices/select_limitテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Masaki Goto <go8ogle@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * View/Elements/CircularNotices/select_limitテスト用Controller
 *
 * @author Masaki Goto <go8ogle@gmail.com>
 * @package NetCommons\CircularNotices\Test\test_app\Plugin\TestCircularNotices\Controller
 */
class TestViewElementsCircularNoticesSelectLimitController extends AppController {

/**
 * select_limit
 *
 * @return void
 */
	public function select_limit() {
		$this->autoRender = true;
	}

}
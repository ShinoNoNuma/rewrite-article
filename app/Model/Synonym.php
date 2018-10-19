<?php
/**
 * Synonym Model
 *
 * @package Synonym
 * @subpackage Synonym.Model
 */
App::uses('AppModel', 'Model');
class Synonym extends AppModel {


  public function wordExist($word) {
      return $this->find('count', array(
         'conditions' => array('Synonym.word' => $word)
      ));
  }

  // public function addressesByUserId($user_id) {
  //     return $this->find('all', array(
  //        'conditions' => array('UserAddress.user_id' => $user_id)
  //     ));
  // }

  public function findSynonymInDatabase($word) {
      return $this->find('first', array(
         'conditions' => array('Synonym.word' => $word)
      ));
  }

  // public function checkAddressBelongUser($address_id,$user_id) {
  //     return $this->find('count', array(
  //        'conditions' => array('UserAddress.id' => $address_id, 'UserAddress.user_id' => $user_id)
  //     ));
  // }


}
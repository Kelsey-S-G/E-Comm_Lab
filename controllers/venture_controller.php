<?php
// controllers/venture_controller.php
require_once(__DIR__ . "/../classes/venture_class.php");

function add_venture_ctr($name, $owner_id, $cat_id, $desc) {
    $venture = new Venture();
    return $venture->add_venture($name, $owner_id, $cat_id, $desc);
}

function get_all_ventures_ctr() {
    $venture = new Venture();
    return $venture->get_all_ventures();
}

function get_my_ventures_ctr($owner_id) {
    $venture = new Venture();
    return $venture->get_my_ventures($owner_id);
}

function update_venture_ctr($id, $name, $cat_id, $desc) {
    $venture = new Venture();
    return $venture->update_venture($id, $name, $cat_id, $desc);
}

function delete_venture_ctr($id) {
    $venture = new Venture();
    return $venture->delete_venture($id);
}
?>
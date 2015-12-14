<?php

// CREATE TABLE `tag` (
//   `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
//   `name` char(32) NOT NULL DEFAULT '',
//   `slug` char(128) NOT NULL DEFAULT '',
//   `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
//   PRIMARY KEY (`id`),
//   UNIQUE KEY `name` (`name`),
//   UNIQUE KEY `slug` (`slug`)
// ) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

// CREATE TABLE `relationships` (
//   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
//   `tagid` smallint(6) NOT NULL DEFAULT '0',
//   `objectid` int(10) NOT NULL DEFAULT '0',
//   PRIMARY KEY (`id`),
//   KEY `tagid` (`tagid`),
//   KEY `objectid` (`objectid`)
// ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

class TagModel extends MY_Model {

    /**
     * 表名
     */
    protected $table = 'tag';

    /**
     * 构造方法
     */
    public function __construct() {
        parent::__construct();
        // required mb_substr function
        if( ! function_exists('mb_substr') ) {
            throw new Exception('Function mb_substr Not Loaded');
        }
    }

    /**
     * 添加名称
     */
    public function addName($name, $slug = NULL) {

        $from = is_null($slug) ? $name : $slug;

        $this->db->insert($this->table, array(
            'name' => $this->getName($name),
            'slug' => $this->getSlug($from)
        ));

        return $this->db->insert_id();
    }

    /**
     * 根据ID修改名称
     */
    public function updateNameById($id, $name) {

        $id = intval($id);

        if( $this->hasName($name, $id) ) {
            return FALSE;
        }

        $data = array('name'=>$this->getName($name));
        $this->db->update($this->table, $data, array('id'=>$id));
        
        return (bool) $this->db->affected_rows();
    }

    /**
     * 根据ID修改别名
     */
    public function updateSlugById($id, $slug) {

        $id = intval($id);

        if( $this->hasSlug($slug, $id) ) {
            return FALSE;
        }

        $data = array('slug'=>$this->getSlug($slug));
        $this->db->update($this->table, $data, array('id'=>$id));
        
        return (bool) $this->db->affected_rows();
    }

    /**
     * 删除
     */
    public function deleteById($id) {

        $this->db->delete($this->table, array('id'=>intval($id)));

        if( ! $this->db->affected_rows() ) {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * 检测名称是否存在
     */
    public function hasName($name, $ignoreId = NULL) {

        if( ! is_null($ignoreId) ) {
            $this->db->where('id !=', intval($ignoreId));
        }

        $this->db->where('name', $this->getName($name));

        return (bool) $this->db->get($this->table)->num_rows();
    }

    /**
     * 检测别名是否存在
     */
    public function hasSlug($slug, $ignoreId = NULL) {

        if( ! is_null($ignoreId) ) {
            $this->db->where('id !=', intval($ignoreId));
        }

        $this->db->where('slug', $this->getSlug($slug));

        return (bool) $this->db->get($this->table)->num_rows();
    }

    /**
     * 获取名称
     */
    protected function getName($name) {
        return mb_substr(trim($name), 0, 32);
    }

    /**
     * 获取别名
     */
    protected function getSlug($name) {
        $slug = str_replace(' ', '-', trim($name));
        $slug = rawurlencode(strtolower($slug));
        return mb_substr($slug, 0, 128);
    }

}

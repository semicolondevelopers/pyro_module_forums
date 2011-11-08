<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Forums extends Module {

    public $version = '1.0';

    public function info() {
        return array(
                'name' => array(
                        'en' => 'Forums',
                ),
                'description' => array(
                        'en' => 'The forum for your site',
                ),
                'frontend' => TRUE,
                'backend' => TRUE,
                'menu' => 'content'
        );
    }

    public function install() {
        $this->dbforge->drop_table('forum_categories');
        $this->dbforge->drop_table('forum_posts');
        $this->dbforge->drop_table('forum_subscriptions');
        $this->dbforge->drop_table('forums');

        $categories = "
                CREATE TABLE IF NOT EXISTS ".$this->db->dbprefix('forum_categories')." (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `title` varchar(100) NOT NULL DEFAULT '',
                `permission` mediumint(2) NOT NULL DEFAULT '0',
                PRIMARY KEY (`id`)
                ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Splits forums into categories' " ;

        $posts = "
                CREATE TABLE IF NOT EXISTS ".$this->db->dbprefix('forum_posts')." (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `forum_id` int(11) NOT NULL DEFAULT '0',
                `author_id` int(11) NOT NULL DEFAULT '0',
                `parent_id` int(11) NOT NULL DEFAULT '0',
                `title` varchar(100) NOT NULL DEFAULT '',
                `content` text NOT NULL,
                `type` tinyint(1) NOT NULL DEFAULT '0',
                `is_locked` tinyint(1) NOT NULL DEFAULT '0',
                `is_hidden` tinyint(1) NOT NULL DEFAULT '0',
                `created_on` int(11) NOT NULL DEFAULT '0',
                `updated_on` int(11) NOT NULL DEFAULT '0',
                `view_count` int(11) NOT NULL DEFAULT '0',
                `sticky` tinyint(1) NOT NULL DEFAULT '0',
                PRIMARY KEY (`id`)
                ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ";

        $subscriptions = "
                CREATE TABLE IF NOT EXISTS ".$this->db->dbprefix('forum_subscriptions')." (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `topic_id` int(11) NOT NULL DEFAULT '0',
                `user_id` int(11) NOT NULL DEFAULT '0',
                PRIMARY KEY (`id`)
                ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ";

        $forums = "
                CREATE TABLE IF NOT EXISTS ".$this->db->dbprefix('forums')." (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `title` varchar(100) NOT NULL DEFAULT '',
		  `description` varchar(255) NOT NULL DEFAULT '',
		  `category_id` int(11) NOT NULL DEFAULT '0',
		  `permission` int(2) NOT NULL DEFAULT '0',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Forums are the containers for threads and topics.' ";


        if($this->db->query($categories) && $this->db->query($posts)
           && $this->db->query($subscriptions) && $this->db->query($forums)) {
            return TRUE;
        }
    }
    public function uninstall() {
        if($this->dbforge->drop_table('forum_categories') &&
            $this->dbforge->drop_table('forum_posts') &&
            $this->dbforge->drop_table('forum_subscriptions') &&
            $this->dbforge->drop_table('forums')
                )
            {
            return TRUE;
            }
    }


    public function upgrade($old_version) {
        // Your Upgrade Logic
        return TRUE;
    }

    public function help() {
        // Return a string containing help info
        // You could include a file and return it here.
        return "<h4>Overview</h4>
		<p>The Forum module is basic tool to add the forum section for your site.</p>
		<h4>Creating Forum</h4>
		<p> Tutorial coming soon!! </p>";
    }
}
/* End of file details.php */

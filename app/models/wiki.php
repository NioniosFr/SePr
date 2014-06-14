<?php
if (! defined('CW'))
    exit('invalid access');

class WikiModel
{

    /**
     * Retrieves all the information of all pages.
     *
     * If a user name is given, it will retrieve all pages where last editor was that user.
     *
     * @param string $user
     *            a user name
     * @return NULL multidimensional An array of pages arrays.
     */
    function getPagesOverview($user = '')
    {
        global $db;
        if (empty($user)) {
            $res = $db->select("SELECT * FROM `page`;");
        } else {
            $res = $db->select(sprintf("SELECT * FROM `page` WHERE `last_edited_by` = '%s';", mysql_escape_string($user)));
        }

        if (! isset($res) || count($res) <= 0) {
            return null;
        } else {
            $pages = array();
            foreach ($res as $page) {
                $page_array = array();
                $page_array['id'] = $page['page_id'];
                $page_array['title'] = $page['title'];
                $page_array['content'] = $page['text'];
                $page_array['created'] = $page['created'];
                $page_array['modified'] = $page['modified'];
                $page_array['lastEditor'] = $page['last_edited_by'];
                $pages[] = $page_array;
            }
            return $pages;
        }
    }

}
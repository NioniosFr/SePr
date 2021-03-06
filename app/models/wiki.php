<?php
if (! defined('CW'))
    exit('invalid access');

global $path;
require_once $path['lib'].'htmlpurifier-4.6.0-standalone/HTMLPurifier.standalone.php';

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
            $res = $db->select("SELECT * FROM `page` WHERE `last_edited_by` = %s;", array(
                $user
            ));
        }

        if (! isset($res) || count($res) <= 0) {
            return null;
        } else {
            $pages = array();
            foreach ($res as $page) {
                $pages[] = $this->getPage($page);
            }
            return $pages;
        }
    }

    /**
     * Sets the page array and returns it.
     * Accepts a page array with all fields from the DB.
     *
     * @param array $array
     *            The row as returned from the db.
     */
    private function getPage($page)
    {
        $page_array = array();
        $page_array['id'] = $page['page_id'];
        $page_array['title'] = $page['title']; //htmlspecialchars()
        $page_array['content'] = $page['text']; //htmlspecialchars()
        $page_array['created'] = $page['created'];
        $page_array['modified'] = $page['modified'];
        $page_array['lastEditor'] = $page['last_edited_by'];
        return $page_array;
    }

    /**
     * Edit a page by its Id.
     *
     * @param numeric $pageId
     *            The page id.
     * @param string $userName
     *            The user name that performs the update.
     * @param array $params
     *            Parameters in key=>value form
     * @return boolean True on success, false otherwise
     */
    function editPage($pageId, $userName, $params)
    {
        global $db;

        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        $sanitized['title'] = $purifier->purify($params['title']);
        $sanitized['content'] = $purifier->purify($params['content']);

        $res = $db->execute("UPDATE `page` SET `last_edited_by`= %s, `title`= %s, `text`= %s, `modified` = %s WHERE `page_id` = %d ;", array(
            $userName,
            $sanitized['title'],
            $sanitized['content'],
            date('Y-m-d H:i:s'),
            $pageId
        ));
        if ($res == null || count($res) <= 0) {
            return false;
        } else {
            return $res;
        }
    }

    /**
     * Insert a new page into the page database table.
     *
     * @param string $user
     *            The user name of the user that adds it.
     * @param array $params
     *            Parameters in key=>value form
     * @return boolean True on success, false otherwise
     */
    function addPage($user, $params)
    {
        global $db;

        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        $sanitized['title'] = $purifier->purify($params['title']);
        $sanitized['content'] = $purifier->purify($params['content']);

        $res = $db->execute("INSERT INTO `page` (`last_edited_by`,`title`,`text`, `created`)VALUES(%s,%s,%s,%s);", array(
            $user,
            $sanitized['title'],
            $sanitized['content'],
            date('Y-m-d H:i:s')
        ));
        if ($res == null) {
            return false;
        } else {
            return $res;
        }
    }

    /**
     * Retrieve all page details as array from the DB with a given ID.
     *
     * @param numeric $id
     *            The page id.
     * @return boolean array if not existant, a page array.
     */
    function getPageById($id)
    {
        global $db;
        $res = $db->select("SELECT * FROM `page` WHERE `page_id` = %d;", array(
            $id
        ));
        if ($res == null || ! $res) {
            return false;
        } else {
            return $this->getPage($res);
        }
    }

    /**
     * Deletes a page from the database with the given id.
     *
     * @param numeric $id
     */
    function deletePage($id)
    {
        global $db;
        $res = $db->execute("DELETE FROM `page` WHERE `page_id` = %d;", array(
            $id
        ));
        if ($res == null) {
            return false;
        } else {
            return $res;
        }
    }
}

<?php

namespace Service;
error_reporting(E_ALL);
ini_set('display_errors', 'On');

use Entity\Article;
use Entity\BaseEntity;
use Entity\User;

/**
 * Class ArticleManager
 * @package Service
 */
class ArticleManager extends EntityManager
{
    /**
     * ArticleManager constructor.
     */
    public function __construct()
    {
        $this->myDB = new MysqlConfig();
    }

    /**
     * @param int $id
     * @return BaseEntity|null
     * @throws \Exception
     */
    function getById(int $id): ?BaseEntity
    {
        $query = "SELECT * FROM blog WHERE id = $id";
        $selectById = mysqli_query($this->myDB->connect(), $query);
        $rows = mysqli_fetch_array($selectById, MYSQLI_ASSOC);
        $blogger = new User(null, null, null, null);
        if (!empty($rows['blogger'])) {
            $query = "SELECT * FROM users WHERE id =" . $rows['blogger'];
            $selectByIdU = mysqli_query($this->myDB->connect(), $query);
            $rowsUser = mysqli_fetch_array($selectByIdU, MYSQLI_ASSOC);
            $blogger = new User($rows['blogger'], $rowsUser['name'], $rowsUser['surname'], $rowsUser['email']);
        }
        $object = new Article($id, $rows['title'], $rows['text'], $blogger);
        return $object;
    }

    /**
     * @param BaseEntity $object
     * @throws \Exception
     */
    public function save(BaseEntity $object)
    {
        $query = "SELECT COUNT(id) AS id1 FROM blog WHERE id =" . $object->getId();
        $selectById = mysqli_query($this->myDB->connect(), $query);
        $rows = mysqli_fetch_array($selectById, MYSQLI_ASSOC);
        if (empty($rows['id1'])) {
            $query = "INSERT INTO `blog` (blog.id,blog.title, blog.text,blog.blogger) 
                        VALUES ('" . $object->getId() . "','" . $object->getTitle() . "','
                        " . $object->getText() . "','" . $object->getBlogger() . "')";
        } else {
            $query = "UPDATE blog SET title=" . $object->getTitle() . ", text =" . $object->getText() .
                ", blogger=" . $object->getBlogger() . "WHERE id=" . $object->getId();
        }
        $selectById = mysqli_query($this->myDB->connect(), $query);

    }

}


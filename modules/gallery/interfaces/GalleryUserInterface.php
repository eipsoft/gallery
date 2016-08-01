<?php
/**
 * GalleryUserInterface.php
 * @author Sergey Semenov
 */
namespace app\modules\gallery\interfaces;
/**
 * Interface GalleryUserInterface
 * @package rmrevin\yii\module\Comments\interfaces
 */
interface GalleryUserInterface
{
    /**
     * Return list of all users as [userId] => userName
     *
     * @return array
     */

    public function getAllUsers();
}
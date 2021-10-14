<?php

namespace App\Entity\Post;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class, readOnly=true)
 * @ORM\Table(name="post")
 */
class Item extends Post
{

    public function __construct()
    {
        parent::__construct();
        $this->type = 'item';
    }

    public function getUpgrades(): array
    {
        $upgrades = [];

        // max upgrade example: sword +0 to sword +10
        for ($i = 0; $i < 10; $i++)
        {
            $upgrades[$i] = [
                'name' => '',
                'requirements_wear' => [],
                'requirements' => [],
                'attributes' => []
            ];
            foreach ($this->taxonomies as $tx)
            {
                switch($tx->getTerm())
                {
                    case 'item_name_' . $i:
                        $upgrades[$i]['name'] = $tx->getValue();
                    break;
                    case 'item_requirement_' . $i:
                        $upgrades[$i]['requirements_wear'][] = $tx->getValue();
                    break;
                    case 'upgrade_requirement_' . $i:
                        $upgrades[$i]['requirements'][] = $tx->getValue();
                    break;
                    case 'item_attribute_' . $i:
                        $upgrades[$i]['attributes'][] = $tx->getValue();
                    break;
                }
            }
        }

        $k = 0;
        foreach ($upgrades as &$upgrade) {
            if (empty($upgrade['name'])) {
                unset($upgrades[$k]);
            }
            $k++;
        }

        return $upgrades;
    }

}
<?php

namespace App\Controller\Admin;

use App\Form\ImportDatabaseCategoriesType;
use App\Form\ImportDatabaseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImportController extends AbstractController
{
    /**
     * @Route("/admin/import", name="admin_import")
     */
    public function index(Request $request): Response
    {

        $importForm = $this->createForm(ImportDatabaseType::class, null, [
            'doctrine' => $this->getDoctrine()
        ]);
        $importForm->handleRequest($request);
        if ($importForm->isSubmitted() && $importForm->isValid()) {
            //$this->checkConnection($importForm);
        }

        return $this->render('admin/import/index.html.twig', [
            'importForm' => $importForm->createView(),
        ]);
    }

    private function checkConnection(FormInterface $form)
    {
        // test connection
        try {
            $params = $form->getData();
            $conn = new \mysqli(
                $params['db_host'],
                $params['db_user'],
                $params['db_pass'],
                $params['db_name'],
                $params['db_port']
            );
            if (!$conn->connect_errno) {
                $this->addFlash('success', 'Database connected successfully!');
            } else {
                throw new \ErrorException();
            }
        } catch (\ErrorException $ee) {
            $this->addFlash('warning', 'Error connection');
        }
        
        /*
        $query = "";
        $stmt = $this->conn->prepare($query);
        */

    }
    private function checkMapping(FormInterface $form)
    {
        /*
        ITEM_NONE,              //0
        ITEM_WEAPON,            //1
        ITEM_ARMOR,             //2
        ITEM_USE,               //3
        ITEM_AUTOUSE,           //4
        ITEM_MATERIAL,          //5
        ITEM_SPECIAL,           //6
        ITEM_TOOL,              //7
        ITEM_LOTTERY,           //8
        ITEM_ELK,               //9
        ITEM_METIN,             //10
        ITEM_CONTAINER,         //11
        ITEM_FISH,              //12
        ITEM_ROD,               //13
        ITEM_RESOURCE,          //14
        ITEM_CAMPFIRE,          //15
        ITEM_UNIQUE,            //16
        ITEM_SKILLBOOK,         //17
        ITEM_QUEST,             //18
        ITEM_POLYMORPH,         //19
        ITEM_TREASURE_BOX,      //20
        ITEM_TREASURE_KEY,      //21
        ITEM_SKILLFORGET,       //22
        ITEM_GIFTBOX,           //23
        ITEM_PICK,              //24
        ITEM_HAIR,              //25
        ITEM_TOTEM,             //26
        ITEM_BLEND,				//27
        ITEM_COSTUME,			//28
        ITEM_DS,				//29
        ITEM_SPECIAL_DS,		//30
        ITEM_EXTRACT,			//31
        ITEM_SECONDARY_COIN,	//32
        ITEM_RING,				//33
        ITEM_BELT,				//34
        */
        $this->addFlash('info', 'mapping!');
    }



}

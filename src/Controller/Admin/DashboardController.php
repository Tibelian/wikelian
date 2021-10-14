<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Design\Menu;
use App\Entity\Design\Slider;
use App\Entity\Post;
use App\Entity\Post\Article;
use App\Entity\Post\Chest;
use App\Entity\Post\Item;
use App\Entity\Post\Map;
use App\Entity\Post\Mission;
use App\Entity\Post\Mob;
use App\Entity\Taxonomy;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {

        $em = $this->getDoctrine();

        $posts = $em->getRepository(Post::class)->findAll();
        $categories = $em->getRepository(Category::class)->findAll();
        $users = $em->getRepository(User::class)->findAll();

        return $this->render('bundles/EasyAdminBundle/welcome.html.twig', [
            'posts' => $posts,
            'categories' => $categories,
            'users' => $users,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            
            // the name visible to end users
            ->setTitle('Wikelian')

            // you can include HTML contents too (e.g. to link to an image)
            //->setTitle('<img src="..."> ACME <span class="text-small">Corp.</span>')

            // the path defined in this method is passed to the Twig asset() function
            #->setFaviconPath('favicon.svg')

            // the domain used by default is 'messages'
            #->setTranslationDomain('my-custom-domain')

            // there's no need to define the "text direction" explicitly because
            // its default value is inferred dynamically from the user locale
            #->setTextDirection('ltr')

            // set this option if you prefer the page content to span the entire
            // browser width, instead of the default design which sets a max width
            #->renderContentMaximized()

            // set this option if you prefer the sidebar (which contains the main menu)
            // to be displayed as a narrow column instead of the default expanded design
            #->renderSidebarMinimized()

            // by default, all backend URLs include a signature hash. If a user changes any
            // query parameter (to "hack" the backend) the signature won't match and EasyAdmin
            // triggers an error. If this causes any issue in your backend, call this method
            // to disable this feature and remove all URL signature checks
            #->disableUrlSignatures()

            // by default, all backend URLs are generated as absolute URLs. If you
            // need to generate relative URLs instead, call this method
            #->generateRelativeUrls()
            ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToRoute('Back to wiki', 'fa fa-arrow-left', 'homepage');

        yield MenuItem::section("Articles");
        

        yield MenuItem::subMenu('Posts', 'fa fa-newspaper')->setSubItems([
            MenuItem::linkToCrud('Article', 'fa fa-file-alt', Article::class),
            MenuItem::linkToCrud('Chest', 'fa fa-suitcase', Chest::class),
            MenuItem::linkToCrud('Item', 'fa fa-cube', Item::class),
            MenuItem::linkToCrud('Map', 'fa fa-map', Map::class),
            MenuItem::linkToCrud('Mission', 'fa fa-clipboard-check', Mission::class),
            MenuItem::linkToCrud('Mob', 'fa fa-dragon', Mob::class),
        ]);

        
        yield MenuItem::linkToCrud('Category', 'fa fa-tags', Category::class);
        yield MenuItem::linkToCrud('Taxonomy', 'fa fa-cubes', Taxonomy::class);

        yield MenuItem::section("Design");
        yield MenuItem::linkToCrud('Menu', 'fa fa-list', Menu::class);
        yield MenuItem::linkToCrud('Carousel', 'fa fa-images', Slider::class);

        yield MenuItem::section("Settings");
        yield MenuItem::linkToCrud('Users', 'fa fa-users', User::class);
        
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}

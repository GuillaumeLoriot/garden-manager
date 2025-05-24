<?php

namespace App\Controller\Admin;

use App\Entity\Area;
use App\Entity\Family;
use App\Entity\Image;
use App\Entity\Plant;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{

    public function index(): Response
    {

        // Option 1. You can make your dashboard redirect to some common page of your backend

        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(PlantCrudController::class)->generateUrl());
        //
        // 1.1) If you have enabled the "pretty URLs" feature:
        // return $this->redirectToRoute('admin_user_index');
        //
        // 1.2) Same example but using the "ugly URLs" that were used in previous EasyAdmin versions:
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Garden Manager')
            ->setDefaultColorScheme('dark');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute("Retour à l'acceuil du site", 'fas fa-home', 'app_home')
        ->setCssClass('mb-4');
        yield MenuItem::linkToCrud('Les Plantes', 'fas fa-seedling', Plant::class);
        yield MenuItem::linkToCrud('Les Familles', 'fas fa-leaf', Family::class);
        yield MenuItem::linkToCrud('Les Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Les Zones de culture', 'fas fa-layer-group', Area::class);
        yield MenuItem::linkToCrud('Les Photos de gallerie', 'fas fa-images', Image::class);
    }
}

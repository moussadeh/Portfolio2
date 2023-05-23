<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Projects;
use App\Entity\Skills;
use App\Entity\Specialties;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;


class AdminController extends AbstractDashboardController
{
    private $em;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }
    
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {

        return Dashboard::new()
            ->setTitle('Portfolio')
            ->setLocales(['fr']);
            // ->setCssFiles([
            //     'build/css/admin.css',
            // ]);



        // return Dashboard::new()
        //     ->setTitle('Portfolio')
        //     ->setTranslationDomain('my-custom-domain')
        //     ->setTextDirection('ltr')
        //     ->setFaviconPath('favicon.svg')
        //     ->setLogoPath('images/logo.svg')
        //     ->setLogoWidth(200)
        //     ->setLogoHeight(50)
        //     ->setCssFiles([
        //         'https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css',
        //         'https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap-grid.min.css',
        //         'https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap-reboot.min.css',
        //         'build/css/admin.css',
        //     ])
        //     ->setJsFiles([

    }
    // public function configureAssets(): Assets
    // {
    //     return Assets::new()
    //     ->addCssFile('assets/styles/loader.css')
    //     ->addCssFile('assets/styles/styles.css');
    // }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Projects');
        yield MenuItem::linkToRoute('Projects', 'fa-solid fa-folder-tree', 'admin_projects');
        yield MenuItem::linkToRoute('Catégories', 'fa fa-tags', 'admin_categories');

        yield MenuItem::section('Compétences');
        yield MenuItem::linkToRoute('Spécialitées', 'fa-solid fa-clipboard-list', 'admin_specialities');
        yield MenuItem::linkToRoute('Skills', 'fa-solid fa-list', 'admin_skills');

        yield MenuItem::section('Expérience professionnelle');
        yield MenuItem::linkToRoute('Works', 'fa-solid fa-briefcase', 'admin_works');

        // yield MenuItem::linkToLogout('Logout', 'fa fa-exit');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }

    #[Route('/admin/categories', name: 'admin_categories')]
    public function indexCategories(): Response
    {
        $categories = $this->em->getRepository(Categories::class)->findAll();
        return $this->render('admin/categories/index.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/admin/projects', name: 'admin_projects')]
    public function indexProjects(Request $request): Response
    {
        $projects = $this->em->getRepository(Projects::class)->findByFilter($request->query->all());
        $nbProjects = $this->em->getRepository(Projects::class)->countAll();
        return $this->render('admin/projects/index.html.twig', [
            'projects' => $projects,
            'nbProjects' => $nbProjects,
            'page' => $request->query->get('page',1),
        ]);
    }
    #[Route('/admin/projects/add', name: 'admin_projects_add')]
    public function addProjects(Request $request): Response
    {
        
    }

    #[Route('/admin/specialities', name: 'admin_specialities')]
    public function indexSpecialties(): Response
    {
        $specialities = $this->em->getRepository(Specialties::class)->findAll();
        return $this->render('admin/specialities/index.html.twig', [
            'specialities' => $specialities
        ]);
    }

    #[Route('/admin/skills', name: 'admin_skills')]
    public function indexSkills(): Response
    {
        $skills = $this->em->getRepository(Skills::class)->findAll();
        return $this->render('admin/skills/index.html.twig', [
            'skills' => $skills
        ]);
    }

}

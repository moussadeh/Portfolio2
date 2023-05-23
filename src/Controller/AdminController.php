<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Projects;
use App\Entity\Skills;
use App\Entity\Specialties;
use App\Entity\User;
use App\Entity\Works;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use PHPUnit\Util\Json;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

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

    
    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('@EasyAdmin/page/login.html.twig', [
            // parameters usually defined in Symfony login forms
            'error' => $error,
            'last_username' => $lastUsername,

            // OPTIONAL parameters to customize the login form:

            // the translation_domain to use (define this option only if you are
            // rendering the login template in a regular Symfony controller; when
            // rendering it from an EasyAdmin Dashboard this is automatically set to
            // the same domain as the rest of the Dashboard)
            'translation_domain' => 'admin',

            // by default EasyAdmin displays a black square as its default favicon;
            // use this method to display a custom favicon: the given path is passed
            // "as is" to the Twig asset() function:
            // <link rel="shortcut icon" href="{{ asset('...') }}">
            // 'favicon_path' => '/favicon-admin.svg',

            // the title visible above the login form (define this option only if you are
            // rendering the login template in a regular Symfony controller; when rendering
            // it from an EasyAdmin Dashboard this is automatically set as the Dashboard title)
            'page_title' => 'Portfolio Admin',

            // the string used to generate the CSRF token. If you don't define
            // this parameter, the login form won't include a CSRF token
            'csrf_token_intention' => 'authenticate',

            // the URL users are redirected to after the login (default: '/admin')
                'target_path' => $this->generateUrl('admin'),

            // the label displayed for the username form field (the |trans filter is applied to it)
            'username_label' => 'Username',

            // the label displayed for the password form field (the |trans filter is applied to it)
            'password_label' => 'Password',

            // the label displayed for the Sign In form button (the |trans filter is applied to it)
            'sign_in_label' => 'Log in',

            // the 'name' HTML attribute of the <input> used for the username field (default: '_username')
            // 'username_parameter' => 'my_custom_username_field',

            // the 'name' HTML attribute of the <input> used for the password field (default: '_password')
            // 'password_parameter' => 'my_custom_password_field',

            // whether to enable or not the "forgot password?" link (default: false)
            // 'forgot_password_enabled' => true,

            // the path (i.e. a relative or absolute URL) to visit when clicking the "forgot password?" link (default: '#')
            // 'forgot_password_path' => $this->generateUrl('...', ['...' => '...']),

            // the label displayed for the "forgot password?" link (the |trans filter is applied to it)
            'forgot_password_label' => 'Forgot your password?',

            // whether to enable or not the "remember me" checkbox (default: false)
            'remember_me_enabled' => true,

            // remember me name form field (default: '_remember_me')
            // 'remember_me_parameter' => 'custom_remember_me_param',

            // whether to check by default the "remember me" checkbox (default: false)
            'remember_me_checked' => true,

            // the label displayed for the remember me checkbox (the |trans filter is applied to it)
            'remember_me_label' => 'Se souvenir de moi',
        ]);
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
    #[Route('/admin/projects/new', name: 'admin_projects_new')]
    public function newProject(Request $request): Response
    {
        if ($request->isMethod("POST")) {
            try {
                $project = new Projects();
                $project->setName($request->request->get('name'));
                $code = $request->request->get('name');
                $code = str_replace(' ', '-', $code);
                $code = strtolower($code);
                // Remove accent
                $code = strtr($code, 'àáâãäåçèéêëìíîïñòóôõöùúûüýÿ', 'aaaaaaceeeeiiiinooooouuuuyy');
                // Remove special characters
                $code = preg_replace('/([^.a-z0-9]+)/i', '-', $code);
                $project->setCode($code);

                $project->setExcerpt($request->request->get('excerpt'));
                $project->setThumbnail($request->request->get('thumbnail'));
                $project->setContent($request->request->get('content'));

                $project->setWork($this->em->getRepository(Works::class)->find($request->request->get('work')));
                $project->addCategorie($this->em->getRepository(Categories::class)->find($request->request->get('categorie')));
                $project->setCreatedAt(new \DateTime($request->request->get('createdAt')));

                $this->em->persist($project);
                $this->em->flush();
            } catch (\Throwable $th) {
                throw $th;
            }

            return $this->redirectToRoute('admin_projects');
        }else{
            return $this->render('admin/projects/new.html.twig', 
            [
                'categories' => $this->em->getRepository(Categories::class)->findAll(),
                'works' => $this->em->getRepository(Works::class)->findAll()
            ]);
        }
    }

    #[Route('/admin/projects/edit/{id}', name: 'admin_projects_edit')]
    public function editProject(Request $request, $id): Response
    {
        $project = $this->em->getRepository(Projects::class)->find($id);
        if ($request->isMethod("POST")) {
            try {
                $project->setName($request->request->get('name'));
                $code = $request->request->get('name');
                $code = str_replace(' ', '-', $code);
                $code = strtolower($code);
                // Remove accent
                $code = strtr($code, 'àáâãäåçèéêëìíîïñòóôõöùúûüýÿ', 'aaaaaaceeeeiiiinooooouuuuyy');
                // Remove special characters
                $code = preg_replace('/([^.a-z0-9]+)/i', '-', $code);
                $project->setCode($code);

                $project->setExcerpt($request->request->get('excerpt'));
                $project->setThumbnail($request->request->get('thumbnail'));
                $project->setContent($request->request->get('content'));

                $project->setWork($this->em->getRepository(Works::class)->find($request->request->get('work')));
                $project->addCategorie($this->em->getRepository(Categories::class)->find($request->request->get('categorie')));
                $project->setCreatedAt(new \DateTime($request->request->get('createdAt')));

                $this->em->persist($project);
                $this->em->flush();
            } catch (\Throwable $th) {
                throw $th;
            }

            return $this->redirectToRoute('admin_projects');
        }else{
            return $this->render('admin/projects/edit.html.twig', 
            [
                'project' => $project,
                'categories' => $this->em->getRepository(Categories::class)->findAll(),
                'works' => $this->em->getRepository(Works::class)->findAll()
            ]);
        }
    }
    #[Route('/admin/projects/delete/{id}', name: 'admin_projects_delete')]
    public function deleteProject(Request $request, $id): Response
    {
        $project = $this->em->getRepository(Projects::class)->find($id);
        if ($request->isMethod("POST")) {
            try {
                $this->em->remove($project);
                $this->em->flush();
            } catch (\Throwable $th) {
                throw $th;
            }
            return $this->redirectToRoute('admin_projects');
        }else{
            return $this->render('admin/projects/delete.html.twig',
            [
                'project' => $project
            ]);
        }
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

    #[Route('/logout', name: 'app_logout')]
    public function logout(): Response
    {
    }
}

<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Projects;
use App\Entity\Skills;
use App\Entity\Specialties;
use App\Entity\User;
use App\Entity\Works;
use App\Service\AppManager;
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

    #[Route('/logout', name: 'app_logout')]
    public function logout(): Response
    {
    }


    // ----- CATEGORIES -----

    #[Route('/admin/categories', name: 'admin_categories')]
    public function indexCategories(AppManager $appManager): Response
    {
        $categories = $appManager->getCategories();
        return $this->render('admin/categories/index.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/admin/categories/new', name: 'admin_categories_new')]
    public function newCategories(Request $request, AppManager $appManager): Response
    {
        if ($request->isMethod("POST")) {
            $categorie = new Categories();
            $appManager->saveCategorie($request, $categorie);
            return $this->redirectToRoute('admin_categories');
        }else{
            return $this->render('admin/categories/new.html.twig', 
            [
            ]);
        }
    }

    // #[Route('/admin/categories/{id}/edit', name: 'admin_categories_edit')]
    // public function editCategories(): Response
    // {
    //     $categorie = $this->em->getRepository(Categories::class)->find($id);
    //     if ($request->isMethod("POST")) {
    //         $this->saveCategorie($request, $categorie);
    //         return $this->redirectToRoute('admin_categories');
    //     }else{
    //         return $this->render('admin/categories/edit.html.twig', 
    //         [
    //             'categorie' => $categorie,
    //         ]);
    //     }
    // }

    #[Route('/admin/categories/{id}/delete', name: 'admin_categories_delete')]
    public function deleteCategories($id, Request $request, AppManager $appManager): Response
    {
        $categorie = $appManager->getCategorie($id);
        if ($request->isMethod("POST")) {
            try {
                $this->em->remove($categorie);
                $this->em->flush();
            } catch (\Throwable $th) {
                throw $th;
            }
            return $this->redirectToRoute('admin_categories');
        }else{
            return $this->render('admin/categories/delete.html.twig', 
            [
                'categorie' => $categorie,
            ]);
        }
    }

    #[Route('/admin/projects', name: 'admin_projects')]
    public function indexProjects(Request $request, AppManager $appManager): Response
    {
        $projects = $appManager->getProjects($request->query->all());
        $nbProjects = $appManager->getProjectsCount();
        return $this->render('admin/projects/index.html.twig', [
            'projects' => $projects,
            'nbProjects' => $nbProjects,
            'page' => $request->query->get('page',1),
        ]);
    }
    #[Route('/admin/projects/new', name: 'admin_projects_new')]
    public function newProject(Request $request, AppManager $appManager): Response
    {
        if ($request->isMethod("POST")) {
            $project = new Projects();
            $appManager->saveProject($request, $project);
            return $this->redirectToRoute('admin_projects');
        }else{
            return $this->render('admin/projects/new.html.twig', 
            [
                'categories' => $appManager->getCategories(),
                'works' => $appManager->getWorks()
            ]);
        }
    }

    #[Route('/admin/projects/{id}/edit', name: 'admin_projects_edit')]
    public function editProject(Request $request, $id, AppManager $appManager): Response
    {
        $project = $appManager->getProject($id);
        if ($request->isMethod("POST")) {
            // $project->getCategorie()->clear();
            // $this->em->flush();
            $appManager->saveProject($request, $project);
            return $this->redirectToRoute('admin_projects');
        }else{
            return $this->render('admin/projects/edit.html.twig', 
            [
                'project' => $project,
                'categories' => $appManager->getCategories(),
                'works' => $appManager->getWorks()
            ]);
        }
    }
    #[Route('/admin/projects/{id}/delete', name: 'admin_projects_delete')]
    public function deleteProject(Request $request, $id, AppManager $appManager): Response
    {
        $project = $appManager->getProject($id);
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


    #[Route('/admin/skills', name: 'admin_skills')]
    public function indexSkills(AppManager $appManager): Response
    {
        $skills = $appManager->getSkills();
        return $this->render('admin/skills/index.html.twig', [
            'skills' => $skills
        ]);
    }

    #[Route('/admin/skills/new', name: 'admin_skills_new')]
    public function newSkills(Request $request, AppManager $appManager): Response
    {
        if ($request->isMethod("POST")) {
            $skills = new Skills();
            $appManager->saveSkills($request, $skills);
            return $this->redirectToRoute('admin_skills');
        }else{
            return $this->render('admin/skills/new.html.twig', [
            ]);
        }
    }

    #[Route('/admin/skills/{id}', name: 'admin_skills_edit')]
    public function editSkills($id, Request $request, AppManager $appManager): Response
    {
        $skills = $appManager->getSkill($id);
        if ($request->isMethod("POST")) {
            $appManager->saveSkills($request, $skills);
            return $this->redirectToRoute('admin_skills');
        }else{
            return $this->render('admin/skills/edit.html.twig', [
                'skills' => $skills
            ]);
        }
    }

    #[Route('/admin/skills/{id}/delete', name: 'admin_skills_delete')]
    public function deleteSkills($id, Request $request, AppManager $appManager): Response
    {
        $skills = $appManager->getSkill($id);
        if ($request->isMethod("POST")) {
            try {
                $this->em->remove($skills);
                $this->em->flush();
            } catch (\Throwable $th) {
                throw $th;
            }
            return $this->redirectToRoute('admin_skills');
        }else{
            return $this->render('admin/skills/delete.html.twig',
            [
                'skills' => $skills
            ]);
        }
    }

    #[Route('/admin/specialities', name: 'admin_specialities')]
    public function indexSpecialities(AppManager $appManager): Response
    {
        $specialities = $appManager->getSpecialities();
        return $this->render('admin/specialities/index.html.twig', [
            'specialities' => $specialities
        ]);
    }

    #[Route('/admin/specialities/new', name: 'admin_specialities_new')]
    public function newSpecialities(Request $request, AppManager $appManager): Response
    {
        if ($request->isMethod("POST")) {
            $specialities = new Specialties();
            $appManager->saveSpecialities($request, $specialities);
            return $this->redirectToRoute('admin_specialities');
        }else{
            return $this->render('admin/specialities/new.html.twig', [
            ]);
        }
    }

    #[Route('/admin/specialities/{id}', name: 'admin_specialities_edit')]
    public function editSpecialities($id, Request $request, AppManager $appManager): Response
    {
        $specialities = $appManager->getSpecialitie($id);
        if ($request->isMethod("POST")) {
            $appManager->saveSpecialities($request, $specialities);
            return $this->redirectToRoute('admin_specialities');
        }else{
            return $this->render('admin/specialities/edit.html.twig', [
                'specialities' => $specialities
            ]);
        }
    }

    #[Route('/admin/specialities/{id}/delete', name: 'admin_specialities_delete')]
    public function deleteSpecialities($id, Request $request, AppManager $appManager): Response
    {
        $specialities = $appManager->getSpecialitie($id);
        if ($request->isMethod("POST")) {
            try {
                $this->em->remove($specialities);
                $this->em->flush();
            } catch (\Throwable $th) {
                throw $th;
            }
            return $this->redirectToRoute('admin_specialities');
        }else{
            return $this->render('admin/specialities/delete.html.twig',
            [
                'specialities' => $specialities
            ]);
        }
    }

    
    #[Route('/admin/works', name: 'admin_works')]
    public function indexWorks(AppManager $appManager): Response
    {
        $works = $appManager->getWorks();
        return $this->render('admin/works/index.html.twig', [
            'works' => $works
        ]);
    }

    #[Route('/admin/works/new', name: 'admin_works_new')]
    public function newWork(Request $request, AppManager $appManager): Response
    {
        if ($request->isMethod("POST")) {
            $works = new Works();
            $appManager->saveWork($request, $works);
            return $this->redirectToRoute('admin_works');
        }else{
            return $this->render('admin/works/new.html.twig', [
                'worksTypes' => $appManager->getWorksTypes(),
                'projects'=> $appManager->getProjects($request->query->all())
            ]);
        }
    }

    #[Route('/admin/works/{id}', name: 'admin_works_edit')]
    public function editWork($id, Request $request, AppManager $appManager): Response
    {
        $works = $appManager->getWork($id);
        if ($request->isMethod("POST")) {
            $appManager->saveWork($request, $works);
            return $this->redirectToRoute('admin_works');
        }else{
            // dd($works);
            return $this->render('admin/works/edit.html.twig', [
                'works' => $works,
                'worksTypes' => $appManager->getWorksTypes(),
                'projects'=> $appManager->getProjects($request->query->all())
            ]);
        }
    }

    #[Route('/admin/works/{id}/delete', name: 'admin_works_delete')]
    public function deleteWork($id, Request $request, AppManager $appManager): Response
    {
        $works = $appManager->getWork($id);
        if ($request->isMethod("POST")) {
            try {
                $works->getProjects()->clear();
                $this->em->remove($works);
                $this->em->flush();
            } catch (\Throwable $th) {
                throw $th;
            }
            return $this->redirectToRoute('admin_works');
        }else{
            return $this->render('admin/works/delete.html.twig',
            [
                'works' => $works
            ]);
        }
    }

    // private function saveCategorie(Request $request, Categories $categorie)
    // {
    //     try {
    //         $categorie->setName($request->request->get('name'));
    //         $categorie->setCode($this->getCode($request->request->get('name')));
    //         $this->em->persist($categorie);
    //         $this->em->flush();
    //     } catch (\Throwable $th) {
    //         throw $th;
    //     }
    // }

    // private function saveSpecialities(Request $request, Specialties $specialitie)
    // {
    //     try {
    //         $specialitie->setName($request->request->get('name'));
    //         $specialitie->setIcon($request->request->get('icon'));
    //         $specialitie->setPosition($request->request->get('position'));
    //         $specialitie->setContent($request->request->get('content'));
    //         $this->em->persist($specialitie);
    //         $this->em->flush();
    //     } catch (\Throwable $th) {
    //         throw $th;
    //     }
    // }

    // private function saveSkills(Request $request, Skills $skill)
    // {
    //     try {
    //         $skill->setName($request->request->get('name'));
    //         $skill->setIcon($request->request->get('icon'));
    //         $skill->setPosition($request->request->get('position'));
    //         $skill->setPercent($request->request->get('percent'));
    //         $this->em->persist($skill);
    //         $this->em->flush();
    //     } catch (\Throwable $th) {
    //         throw $th;
    //     }
    // }

    // private function saveProject(Request $request, Projects $project)
    // {
    //     try {
    //         $project->setName($request->request->get('name'));
    //         $project->setCode($this->getCode($request->request->get('name')));

    //         $project->setExcerpt($request->request->get('excerpt'));
    //         $project->setThumbnail($request->request->get('thumbnail'));
    //         $project->setUrl($request->request->get('url'));
    //         $project->setContent($request->request->get('content'));
    //         $project->setWork($this->em->getRepository(Works::class)->find($request->request->get('work')));

    //         $project->getCategorie()->clear();
    //         foreach ($request->request->all('categories') as $idCategorie) {
    //             $project->addCategorie($this->em->getRepository(Categories::class)->find($idCategorie));
    //         }
    //         $project->setCreatedAt(new \DateTime($request->request->get('createdAt')));

    //         $this->em->persist($project);
    //         $this->em->flush();
    //     } catch (\Throwable $th) {
    //         throw $th;
    //     }
    // }

    // private function getCode($string)
    // {
    //     $code = str_replace(' ', '-', $string);
    //     $code = strtolower($code);
    //     // Remove accent
    //     $code = strtr($code, 'àáâãäåçèéêëìíîïñòóôõöùúûüýÿ', 'aaaaaaceeeeiiiinooooouuuuyy');
    //     // Remove special characters
    //     $code = preg_replace('/([^.a-z0-9]+)/i', '-', $code);
    //     return $code;
    // }
}

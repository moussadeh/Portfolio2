<?php

namespace App\Service;

use App\Entity\Categories;
use App\Entity\Projects;
use App\Entity\Skills;
use App\Entity\Specialties;
use App\Entity\Works;
use App\Entity\WorksTypes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class AppManager{
    private $em;
    private $repoProjects;
    private $repoCategories;
    private $repoWorks;
    private $repoSkills;
    private $repoSpecialties;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->repoProjects = $this->em->getRepository(Projects::class);
        $this->repoCategories = $this->em->getRepository(Categories::class);
        $this->repoWorks = $this->em->getRepository(Works::class);
        $this->repoWorksTypes = $this->em->getRepository(WorksTypes::class);
        $this->repoSkills = $this->em->getRepository(Skills::class);
        $this->repoSpecialties = $this->em->getRepository(Specialties::class);
    }

    public function getProjects($filters = []){
        return $this->repoProjects->findByFilter($filters);
    }

    public function getProject($id){
        return $this->repoProjects->find($id);
    }

    public function getProjectsCount(){
        return $this->repoProjects->countAll();
    }

    public function getCategories(){
        return $this->repoCategories->findAll();
    }

    public function getCategorie($id){
        return $this->repoCategories->find($id);
    }

    public function getWorks(){
        return $this->repoWorks->findAll();
    }

    public function getWork($id){
        return $this->repoWorks->find($id);
    }

    public function getWorksTypes(){
        return $this->repoWorksTypes->findAll();
    }

    public function getWorksType($id){
        return $this->repoWorksTypes->find($id);
    }

    public function getSkills(){
        return $this->repoSkills->findAll();
    }

    public function getSkill($id){
        return $this->repoSkills->find($id);
    }

    public function getSpecialities(){
        return $this->repoSpecialties->findAll();
    }

    public function getSpecialitie($id){
        return $this->repoSpecialties->find($id);
    }

    public function saveProject(Request $request, Projects $project)
    {
        try {
            $project->setName($request->request->get('name'));
            $project->setCode($this->getCode($request->request->get('name')));

            $project->setExcerpt($request->request->get('excerpt'));
            $project->setThumbnail($request->request->get('thumbnail'));
            $project->setUrl($request->request->get('url'));
            $project->setContent($request->request->get('content'));
            $project->setWork($this->getWork($request->request->get('work')));

            $project->getCategorie()->clear();
            foreach ($request->request->all('categories') as $idCategorie) {
                $project->addCategorie($this->getCategorie($idCategorie));
            }
            $project->setCreatedAt(new \DateTime($request->request->get('createdAt')));

            $this->em->persist($project);
            $this->em->flush();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function saveWork(Request $request, Works $work)
    {
        try {
            $work->setName($request->request->get('name'));
            $work->setCode($this->getCode($request->request->get('name')));
            $work->setJob($request->request->get('job'));

            $work->setUrl($request->request->get('url', null));

            $work->setType($this->getWorksType($request->request->get('type')));
            $work->setContent($request->request->get('content'));

            $work->setStartAt(new \DateTimeImmutable($request->request->get('startAt')));

            if ($request->request->get('endAt', null) != null) {
                $work->setEndAt(new \DateTimeImmutable($request->request->get('endAt')));
            }

            $work->getProjects()->clear();
            foreach ($request->request->all('projects') as $project) {
                $work->addProject($this->getProject($project));
            }
            $this->em->persist($work);
            $this->em->flush();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function saveCategorie(Request $request, Categories $categorie)
    {
        try {
            $categorie->setName($request->request->get('name'));
            $categorie->setCode($this->getCode($request->request->get('name')));
            $this->em->persist($categorie);
            $this->em->flush();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function saveSpecialities(Request $request, Specialties $specialitie)
    {
        try {
            $specialitie->setName($request->request->get('name'));
            $specialitie->setIcon($request->request->get('icon'));
            $specialitie->setPosition($request->request->get('position'));
            $specialitie->setContent($request->request->get('content'));
            $this->em->persist($specialitie);
            $this->em->flush();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function saveSkills(Request $request, Skills $skill)
    {
        try {
            $skill->setName($request->request->get('name'));
            $skill->setIcon($request->request->get('icon'));
            $skill->setPosition($request->request->get('position'));
            $skill->setPercent($request->request->get('percent'));
            $this->em->persist($skill);
            $this->em->flush();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function getCode($string)
    {
        $code = str_replace(' ', '-', $string);
        $code = strtolower($code);
        // Remove accent
        $code = strtr($code, 'àáâãäåçèéêëìíîïñòóôõöùúûüýÿ', 'aaaaaaceeeeiiiinooooouuuuyy');
        // Remove special characters
        $code = preg_replace('/([^.a-z0-9]+)/i', '-', $code);
        return $code;
    }

}
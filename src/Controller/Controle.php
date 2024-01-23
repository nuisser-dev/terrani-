<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Client;
use App\Entity\Terrain;
use App\Entity\Reservation;
use App\Entity\Responsable;
use Doctrine\Persistence\ManagerRegistry;

use DateTime;

class Controle extends AbstractController
{
#[Route('/', name: 'homepage')]
public function home(EntityManagerInterface $entityManager)
{
    $tr=$entityManager->getRepository(Terrain::class)->findAll();


return  $this->render('home/index.html.twig',['ter'=>$tr]);
}
#[Route('/login', name: 'login')]
public function login(Request $request,ManagerRegistry $registry):response
{
$nm='';
$pas='';
if ($request ->isMethod('POST'))
{
    
    $nm=$request ->request ->get('name');
    $pas=$request ->request ->get('pas');
    $role=$request ->request ->get('t1');

if($role==='responsable')
{
    $this->entityManager = $registry->getManager();
        
        $myEntityRepository = $this ->entityManager->getRepository(Responsable::class);
        
        
        $myEntity = $myEntityRepository->findOneBy(['cin' => $nm]);
        $myEntity1 = $myEntityRepository->findOneBy(['pass' => $pas]);
        if ($myEntity &&$myEntity1)
        {
            return $this->redirectToRoute('responsabeldash' ,['idres' =>$myEntity->getCin()]);
        }
        else
        { return  $this->render('user/loginuser.html.twig',['message' =>'mot de passe ou adresse invalid verifier le responsable ' ]);}
}


    if ( $role==='client' && $role)
    {
        $this->entityManager = $registry->getManager();
        
        $myEntityRepository = $this ->entityManager->getRepository(Client::class);
        
        
        $myEntity = $myEntityRepository->findOneBy(['cin' => $nm]);
        $myEntity1 = $myEntityRepository->findOneBy(['pass' => $pas]);
        if ($myEntity &&$myEntity1)
        {
            return $this->redirectToRoute('dash1' ,['id' =>$myEntity->getCin()]);

        }
        else
        {
      
            return  $this->render('user/loginuser.html.twig',['message' =>'mot de passe ou adresse invalid verifier le client ' ]);
        }

    }

    

}


return  $this->render('user/loginuser.html.twig',['name' =>$nm ,'pas' =>$pas]);
}




#[Route('/dash1/{id}', name: 'dash1')]
public function dash(EntityManagerInterface $entityManager, int $id):response
{
    
    $repository = $entityManager->getRepository(Client::class);
    $clients = $repository->find($id);
    $tr=$entityManager->getRepository(Terrain::class)->findAll();
   
return  $this->render('user/dash.html.twig',['client' =>$clients,'ter'=>$tr]);
}
#[Route('/reservation/{idc}:{idt}', name: 'reservation')]
public function reservation(int $idc,int $idt,ManagerRegistry $doctrine,Request $request)
{
$t='';
$t2='';
$t3='';
if ($request ->isMethod('POST'))
{
    $t=$request ->request ->get('t1');
    $t2=$request ->request ->get('t2');
    $t3=$request ->request ->get('t3');
    if ($t && $t2 && $t3 )
    {
        $entityManager = $doctrine->getManager();
        $re = new Reservation();
        $d3=new DateTime($t3);
        $d2=new DateTime($t2);
        if ($d2>$d3)
        {
            return  $this->render('user/reservation.html.twig',['message' =>'verifier votre date svp' ]);
        }
        else
        {
        $d=new DateTime($t);
        $re->setDateresv($d);
        
        $re->setHeuerdeb($d2);
        
        $re->setHeuerfin($d3);
        $re->setStatue('en cours de traitment');
        $repository = $entityManager->getRepository(Client::class);
        $clients = $repository->find($idc);
        $re->setIdclient($clients);
        $repository = $entityManager->getRepository(Terrain::class);
        $terr = $repository->find($idt);
        $re->setIdterrain($terr);
        $entityManager->persist($re);
        $entityManager->flush();
        
       

        return  $this->render('user/reservation.html.twig',['message' =>'reservation fait attendre la reponse par le responsable' ]);
        }

    }
}
   
return  $this->render('user/reservation.html.twig');
}
#[Route('/responsabeldash/{idres}', name: 'responsabeldash')]
public function responsabeldash(int $idres,EntityManagerInterface $entityManager)
{$lst=[];
    $reservations = array();
    $repository = $entityManager->getRepository(Terrain::class);
    $ter = $repository->findBY(['idresp' => $idres]);
    foreach ($ter as $value)
    {
        $reposit = $entityManager->getRepository(Reservation::class);
        $resv = $reposit->findBY(['idterrain' => $value->getIdterrain()]);
        
        array_push($lst, $resv);




    }
return  $this->render('responsable/dashresp.html.twig',['idres'=>$idres,'lst'=>$lst]);
}


#[Route('/listereserve/{idc}', name: 'listereserve')]
public function listereserve( int $idc,EntityManagerInterface $entityManager)
{
    $repository = $entityManager->getRepository(Reservation::class);
    $ter = $repository->findBY(['idclient' => $idc]);
return  $this->render('user/listereserv.html.twig',['reserv'=>$ter,'id'=>$idc]);
}
#[Route('/delete/{id}', name: 'delete')]
public function delete(int $id,EntityManagerInterface $entityManager)
{   
    $repository = $entityManager->getRepository(Reservation::class);
    $ter = $repository->find($id);
    if ($ter)
    {
    
    $entityManager->remove($ter);
    $entityManager->flush();

    return $this->redirectToRoute('dash1' ,['id' =>$ter->getIdclient()->getCin()]);
    }

}
#[Route('/accepte/{idr}:{k}', name: 'accepte')]
public function accepte(int $idr,int $k,EntityManagerInterface $entityManager)
{   
    $repository = $entityManager->getRepository(Reservation::class);
    $ter = $repository->find($idr);
    if ($ter)
    {
    
    $ter->setStatue('accepter');
    $entityManager->flush();

    return $this->redirectToRoute('responsabeldash' ,['idres' =>$k]);
    }

}
#[Route('/annuler/{idr}:{k}', name: 'annuler')]
public function annuler(int $idr,int $k,EntityManagerInterface $entityManager)
{   
    $repository = $entityManager->getRepository(Reservation::class);
    $ter = $repository->find($idr);
    if ($ter)
    {
    
    $ter->setStatue('demande non accepter');
    $entityManager->flush();

    return $this->redirectToRoute('responsabeldash' ,['idres' =>$k]);
    }

}

#[Route('/listeterrain/{id}', name: 'listeterrain')]
public function listeterrain(int $id,EntityManagerInterface $entityManager)
{$lst=[];
    $repository = $entityManager->getRepository(Terrain::class);
    $ter = $repository->findBY(['idresp' => $id]);
   
    if ($ter)
    {
        array_push($lst, $ter);

    }

return  $this->render('responsable/userterrainliste.html.twig',['id'=>$id,'lst'=>$lst]);
}
#[Route('/deleteterr/{id}', name: 'deleteterr')]
public function deleteterr(int $id,EntityManagerInterface $entityManager)
{   
    $repository = $entityManager->getRepository(Terrain::class);
    $ter = $repository->find($id);
    if ($ter)
    {
    
    $entityManager->remove($ter);
    $entityManager->flush();

    return $this->redirectToRoute('listeterrain' ,['id' =>$ter->getIdresp()->getCin()]);
    }

}

#[Route('/modifyterrain/{id}', name: 'modifyterrain')]
public function modif(int $id,EntityManagerInterface $entityManager,Request $request)
{   $t='';
    $t2='';
    $t3='';
    $t4=''; 
    $repository = $entityManager->getRepository(Terrain::class);
    $ter = $repository->find($id);
    if ($request ->isMethod('POST'))
    {
        $t=$request ->request ->get('t1');
        $t2=$request ->request ->get('t2');
        $t3=$request ->request ->get('t3');
      
        $ter = $repository->find($id);
        $ter->setNom($t);
        $ter->setAdresse($t2);
        $ter->setStatue($t3);
       
        $entityManager->persist($ter);
        $entityManager->flush();
        
        
       
        return $this->redirectToRoute('listeterrain' ,['id' =>$ter->getIdresp()->getCin()]);
    
    }
    else
    {



    
    if ($ter)
    {
 
    return $this->render('responsable/modifterrain.html.twig' ,['ter'=>$ter,'id' =>$ter->getIdresp()->getCin()]);
    }
   

    
}}
#[Route('/cree', name: 'cree')]
public function cree(EntityManagerInterface $entityManager,Request $request)
{
    $t='';
    $t2='';
    $t3='';
    $t4=''; 
    $t5=''; 
    $t10=''; 
    $t20=''; 
    if ($request ->isMethod('POST'))
    {
        $t20=$request ->request ->get('adresse');
        $t=$request ->request ->get('nom');
        $t10=$request ->request ->get('prenom');
        $t4=$request ->request ->get('age');
        $t3=$request ->request ->get('password');
        
        $t5=$request ->request ->get('t1');
        if($t5 ==='responsable')
        {
        $x =new Responsable();
        $x->setNom($t);
        $x->setPrenom($t10);
        $x->setAdresse($t20);
        $x->setAge($t4);
        $x->setPass($t3);
        $entityManager->persist($x);
        $entityManager->flush();
        return $this->render('user/loginuser.html.twig' );


        }
        if($t5 ==='client')
        {
        $x =new Client();
        $x->setNom($t);
        $x->setPrenom($t10);
        $x->setAdresse($t20);
        $x->setAge($t4);
        $x->setPass($t3);
        $entityManager->persist($x);
        $entityManager->flush();
        return $this->render('user/loginuser.html.twig' );


        }
    }
 


return  $this->render('createcompte.html.twig');
}
}

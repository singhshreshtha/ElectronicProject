<?php
 namespace App\EventSubscriber;


use App\Entity\Products;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
 use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
 use Symfony\Component\EventDispatcher\EventSubscriberInterface;
 use Symfony\Component\Security\Core\Security;
 use Symfony\Component\String\Slugger\SluggerInterface;

 class ProductsEntitySubscriber implements EventSubscriberInterface {
     private $slugger;

     public function __construct(Security $security, SluggerInterface $slugger) {
         $this->slugger = $slugger;
         $this->security = $security;
     }

     public static function getSubscribedEvents(){
         return [
             BeforeEntityPersistedEvent::class => ['setProduct'],
             BeforeEntityUpdatedEvent::class => ['updateProduct'],
             
         ];
     }

     public function setProduct(BeforeEntityPersistedEvent $event){
         $entity = $event->getEntityInstance();
         if ($entity instanceof Products) {
            
             $entity->setCreatedAt(new \DateTime());
             $entity->setUpdatedAt(new \DateTime());
            
             
         }
         
         return;
     }

     public function updateProduct(BeforeEntityUpdatedEvent $event){
         $entity = $event->getEntityInstance();
         if ($entity instanceof Products) {
            
             $entity->setUpdatedAt(new \DateTime());
             
         }
         
         return;
     }
 }
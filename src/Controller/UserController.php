<?php

namespace App\Controller;

use App\Entity\Area;
use App\Entity\Image;
use App\Entity\User;
use App\Form\ImageForm;
use App\Form\UserEditType;
use App\Form\UserRegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormError;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\FileUploader;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;


final class UserController extends AbstractController
{


    // ---------------------USER---------------------------------------------------------------------


    #[Route('/user/{id}', name: 'app_user_profile')]
    public function profile(User $user): Response
    {
        // ici je verifie que c'est le bon user qui cherche à acceder à cette route 
        if ($user !== $this->getUser()) {
            $this->redirectToRoute('app_error_403');
            // ici, je souhaitais juste afficher une page plus sympa que le throw en dessous pour tester. j'ai laisser 
            // les erreurs symphony normales 404, 403 dans le reste du projet.
            // je laisse les 2 ici pour que tu puisse switcher si tu veux tester.
            // throw $this->createAccessDeniedException();
        }
        return $this->render('user/profile.html.twig', ['user' => $user]);
    }


    #[Route('/user/edit/{id}', name: 'app_user_edit')]
    public function edit(User $user, Request $request, EntityManagerInterface $em, FileUploader $fileUploader): Response
    {

        if ($user !== $this->getUser()) {

            // VOIR commentaire dans profile
            $this->redirectToRoute('app_error_403');
            // throw $this->createAccessDeniedException();
        }

        $editForm = $this->createForm(UserEditType::class, $user);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $ProfilePictureFile = $editForm->get('profilePicture')->getData();
            $uploadDir = $this->getParameter('kernel.project_dir') . '/public/images/uploads/user';

            /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $imageFile */
            if ($ProfilePictureFile) {
                $ProfilePictureFileName = $fileUploader->upload($uploadDir, $ProfilePictureFile);
                $user->setProfilePicture($ProfilePictureFileName);
            }

            try {
                // Ici, nettoyage avant de modifier le nom du fichier
                if ($user->getProfilePicture() !== null) {
                    unlink(__DIR__ . "/../../public/images/uploads/user/" . $user->getProfilePicture());
                }
            } catch (\Exception $e) {

                $editForm->addError(new FormError("Impossible de supprimer l'ancienne photo."));
            }
            $em->flush();

            $this->addFlash('success', "Votre profil a bien été mis à jour");

            $this->redirectToRoute('app_user_profile', ['id' => $user->getId()]);
        }

        return $this->render('user/edit.html.twig', ['user' => $user, 'edit_form' => $editForm]);
    }




    // ---------------------USER/GALLERY---------------------------------------------------------------------




    #[Route('/user/gallery/edit', name: 'app_user_gallery_edit')]
    public function editGallery(Request $request, FileUploader $fileUploader, EntityManagerInterface $em): Response
    {
        $image = new Image;

        $form = $this->createForm(ImageForm::class, $image);

        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('fileName')->getData();
            $uploadDir = $this->getParameter('kernel.project_dir') . '/public/images/uploads/users';

            /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $imageFile */
            if ($imageFile) {
                $imageFileName = $fileUploader->upload($uploadDir, $imageFile);
                $image->setFileName($imageFileName)
                    ->setUser($user);

                $em->persist($image);
                $em->flush();
            } else {
                $form->get('fileName')->addError(new FormError("Veuillez sélectionner une image à télécharder."));
            }

        }

        return $this->render('user/gallery/edit.html.twig', [
            'form' => $form,
            'user' => $user,
        ]);
    }



    #[Route('/user/gallery/delete/{id}', name: 'app_user_gallery_delete', methods: ['POST'])]
    public function deleteImage(Image $image, EntityManagerInterface $em, Request $request, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $user = $this->getUser();

        // VOIR commentaire dans profile
        if ($image->getUser() !== $user) {
            $this->redirectToRoute('app_error_403');

            // throw $this->createAccessDeniedException();
        }

        // ici je gère le csrf token manuellement car je ne fais pas de form type mais je veux garder la même sécurité 
        $submittedToken = $request->request->get('_token');

        if ($csrfTokenManager->isTokenValid(new CsrfToken('delete_image' . $image->getId(), $submittedToken))) {
            $em->remove($image);
            $em->flush();
        }

        // ici je ne gèrerai pas la suppression du fichier en lui même car pour le moment, ce sont des fichiers généric 
        // stocké au même endroit pour tout mes users. Je pourrai réutiliser unlink comme dans le edit d'un user mais 
        // je devrais alors faire la gestion des uploads des emplacements des images de chaque users. pour le moment, 
        // les templates rendent les images de public/images/default et les uploads se font vers public/images/uploads/users
        // mais je dois encore gérer l'affichage dynamique en fonction de où est stocké l'image 
        // ce qui me permettra de gitter uniquement le dossier default.
        // j'aurais préféré le faire, mais je ne pense pas en avoir le temps


        $em->remove($image);
        $em->flush();

        return $this->redirectToRoute('app_user_gallery_edit');
    }



    // ---------------------USER/AREA---------------------------------------------------------------------




    #[Route('/user/area/list', name: 'app_user_area_list')]
    public function areaList(): Response
    {
        $user = $this->getUser();
        // ici je verifie que c'est le bon user qui cherche à acceder à cette route 
        if ($user !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $areas = $user->getAreas();

        return $this->render('user/area/list.html.twig', ['areas' => $areas]);
    }


    #[Route('/user/area/{id}', name: 'app_user_area_detail')]
    public function areaDetail(Area $area): Response
    {
        $user = $this->getUser();

        // ici je vérifie que cette zone appartient bien à l'utilisateur connecté
        if ($area->getUser() !== $user) {
            throw $this->createAccessDeniedException("Vous ne pouvez pas accéder à cette zone.");
        }

        return $this->render('user/area/item.html.twig', [
            'area' => $area
        ]);
    }



    // ---------------------REGISTER---------------------------------------------------------------------



    #[Route('/register', name: 'app_register')]
    public function register(EntityManagerInterface $em, Request $request, FileUploader $fileUploader): Response
    {
        $user = new User();
        $registerForm = $this->createForm(UserRegistrationType::class, $user);

        $registerForm->handleRequest($request);

        if ($registerForm->isSubmitted() && $registerForm->isValid()) {

            $ProfilePictureFile = $registerForm->get('profilePicture')->getData();
            $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads/images/users';

            /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $imageFile */
            if ($ProfilePictureFile) {
                $ProfilePictureFileName = $fileUploader->upload($uploadDir, $ProfilePictureFile);
                $user->setProfilePicture($ProfilePictureFileName);
            } else {
                $user->setProfilePicture('generic-user.jpg');
            }
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "Merci de votre insciption, vous pouvez maintenant vous connecter");

            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/register.html.twig', ['register_form' => $registerForm]);
    }

}

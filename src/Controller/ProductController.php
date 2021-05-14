<?php

namespace App\Controller;

use App\Entity\Product;
use App\Services\FileUploader;
use App\Form\CreateProductFormType;
use App\Form\UpdateProductFormType;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/product", name="product")
     */
    public function index(
        ProductRepository $productRepo,
        CategoryRepository $categoryRepo,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $products = $productRepo->findAll();
        $categories = $categoryRepo->findAll();

        $products = $paginator->paginate(
            $products, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/product-detail/{id}", name="product-detail")
     */
    public function productDetail(
        ProductRepository $productRepo,
        Request $request
    ): Response {

        $id = $request->get('id');
        $product = $productRepo->find($id);

        return $this->render(
            'product/detail.html.twig',
            ['product' => $product]
        );
    }

    /**
     * @Route("/product-delete/{id}", name="product-delete", methods={"GET","POST"})
     */
    public function productDelete(Product $product): Response
    {
        $em = $this->em;
        $em->remove($product);
        $em->flush();
        return $this->redirectToRoute('product');
    }

    /**
     * @Route("/product-create", name="product-create")
     */
    public function productCreate(
        Request $request,
        FileUploader $fileUploader
    ): Response {


        $product = new Product();

        $form = $this->createForm(CreateProductFormType::class, $product);

        $form->handleRequest($request);
        $em = $this->em;
        if ($form->isSubmitted() && $form->isValid()) {
            // $file = $request->files->get('product')['attachment'];

            $images = $form->get('image')->getData();

            if ($images) {

                $filename = $fileUploader->uploadFile($images);
                $product->setImage($filename);

                $em->persist($product);
                $em->flush();
            }

            // return new Response('Product new '. $item->getId());
            return $this->redirectToRoute('product');
        }
        return $this->render(
            'product/product-create.html.twig',
            [
                'productForm' => $form->createView()
            ]
        );
    }


    /**
     * @Route("/product/{id}/edit", name="proUpdate",  methods={"GET","POST"})
     */
    public function productUpdate(
        Request $request,
        ProductRepository $productRepo,
        FileUploader $fileUploader

    ): Response {
        $id = $request->get('id');
        $product = $productRepo->find($id);

        $form = $this->createForm(UpdateProductFormType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->em;
            $images = $form->get('image')->getData();
            
            if ($images) {
                
                $filename = $fileUploader->uploadFile($images);
                $product->setImage($filename);
                
                $em->persist($product);
                $em->flush();
            }
            return $this->redirectToRoute('product');
        }

        return $this->render(
            'product/product-update.html.twig',
            ['formUpdateProduct' => $form->createView()]
        );
    }

    /**
     * @Route("/search", name="product-search")
     */
    public function searchProduct(
        Request $request,
        ProductRepository $productRepo
    ): Response {

        $nameProduct = $request->get('name');
        $products = $productRepo->findByProductName($nameProduct);
        return $this->render(
            'product/search.html.twig',
            ['products' => $products]
        );
    }
}

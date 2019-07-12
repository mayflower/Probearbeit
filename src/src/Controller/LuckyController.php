<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController extends AbstractController
{
    /**
     * @Route("/blog", name="blog_list")
     */
    public function number(){

        /*
        $number = random_int(-10, 15);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'

        );

        */

        return new Response('test');



    }

    /**
     * @Route("/highandlow", name="test")
     */

    public function test(){

        $werte = array("1 2 3 4 5", "1 2 -3 4 5", "1 9 3 4 -5","13 -222 48 3", "-2 -88 -548 -89");
        $ausgabe = "";


        foreach($werte as $wert){
            $zahlen = explode(" " ,$wert);

            $ergebnisMin = min($zahlen);
            $ergebnisMax = max($zahlen);

            $ausgabe .= "Ausgabe: $ergebnisMax $ergebnisMin\n";
        }


        return new Response($ausgabe);
    }

}
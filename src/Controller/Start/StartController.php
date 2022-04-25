<?php

namespace App\Controller\Start;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Form\ExchangeRates\ExchangeRatesType;
use App\Service\Frankfurter;

class StartController extends Controller {

    private $baseCurrency = 'PLN';
    private $currencies = ['EUR', 'USD', 'GBP', 'CZK'];

    /**
     * @Route("/{_locale}", name="rates", defaults={"_locale": null})
     * @Method({"GET"})
     */
    public function index(Frankfurter $frankfurter, Request $request)
    {
        $form = $this->createForm(ExchangeRatesType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $today = date("Y-m-d");
            $date = date_format($form->getData()['date'], "Y-m-d");

            $ratesToday = $frankfurter->get($today, $this->baseCurrency, $this->currencies); 
            $ratesRequested = $frankfurter->get($date, $this->baseCurrency, $this->currencies);
            // Prepare API data for twig template
            $rates = $this->prepareData($ratesToday['rates'], $ratesRequested['rates']);

            return $this->render('start/start.html.twig', array(
                'form' => $form->createView(),
                'rates' => $rates,
                'baseCurrency' => $this->baseCurrency
            ));
        }

        return $this->render('start/start.html.twig', array(
            'form' => $form->createView()
        ));
    }

    // Takes currency rates from Frankfurter API, returns a 2-dimensional array with currency names and rates
    private function prepareData(?array $ratesToday, ?array $ratesRequested) :array
    {
        $data = array();

        foreach($ratesToday as $currency=>$rate) {
            array_push($data, array(
                'currency' => $currency,
                'today' => $rate,
                'date' => $ratesRequested[$currency])
            );
        }

        return $data;
    }

}
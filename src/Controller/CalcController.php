<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CalcController extends AbstractController
{
    private const DEFAULT_OPERATORS = ['+', '-', '/', '*'];
    private const DEFAULT_INTEGERS = [1, 2, 3, 4, 5, 6, 7, 8, 9, 0];

    #[Route('/calc', name: 'app_calc')]
    public function index(Request $request): Response
    {
        return $this->render('calc/index.html.twig', [
            'operators' => self::DEFAULT_OPERATORS,
            'integers' => self::DEFAULT_INTEGERS,
            'result' => $request->query->get('result'),
            'expression' => $request->query->get('expression')
        ]);
    }

    #[Route('/calculate', name: 'calc', methods: ['GET'])]
    public function calc(Request $request): Response
    {
        $expression = $request->query->get('expression');
        $expressionArray = explode(' ', $expression);
        $result = 0;

        foreach ($expressionArray as $key => $value) {
            if ($key === 0) {
                $result += (int)$value;
            }

            if (!isset($expressionArray[$key + 1])) break;
            $next = $expressionArray[$key + 1];
            if (!$next) break;

            switch ($value) {
                case '+':
                    $result += (int)$next;
                    break;
                case '-':
                    $result -= (int)$next;
                    break;
                case '*':
                    $result *= (int)$next;
                    break;
                case '/':
                    $result /= (int)$next;
                    break;
            }
        }

        return $this->redirectToRoute('app_calc', [
            'expression' => $expression,
            'result' => $result,
        ]);
    }
}

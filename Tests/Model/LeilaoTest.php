<?php

declare(strict_types=1);

namespace Alura\Leilao\Tests\Model;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{
    public function testLeilaoNaoDeveReceberLancesRepetidos()
    {
        $leilao = new Leilao("Corsa");

        $ana = new Usuario("Ana");

        $leilao->recebeLance(new Lance($ana, 1000));
        $leilao->recebeLance(new Lance($ana, 2000));

        self::assertCount(1, $leilao->getLances());
        self::assertEquals(1000, $leilao->getLances()[0]->getValor());
    }
    /**
     * @dataProvider geraLances
     */
    public function testLeilaoDeveReceberLances(
        int $qtdLances,
        Leilao $leilao,
        array $valores
    ) {
        self::assertCount($qtdLances, $leilao->getLances());

        foreach ($valores as $i => $valor) {
            self::assertEquals($valor, $leilao->getLances()[$i]->getValor());
        }
    }

    public function geraLances()
    {
        $joao = new Usuario("Joao");
        $maria = new Usuario("Maria");

        $leilaoCom2Lances = new Leilao("porche");
        $leilaoCom2Lances->recebeLance(new Lance($joao, 2000));
        $leilaoCom2Lances->recebeLance(new Lance($maria, 3000));

        $leilaoCom1Lance = new Leilao("Fusca 0km");
        $leilaoCom1Lance->recebeLance(new Lance($maria, 5000));

        return [
            "2 - lances" => [2, $leilaoCom2Lances, [2000, 3000]],
            "1 - lance" => [1, $leilaoCom1Lance, [5000]]
        ];
    }
}
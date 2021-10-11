<?php

namespace App\Helpers;

class ValidateDocument
{
    private string $number;
    private string $type;
    private bool $valid;

    public function handle(string $number): array
    {
        $this->setNumber($number);
        $this->setType();

        return [
            'is_valid'      => $this->valid,
            'number'        => $this->number,
            'type'          => $this->type,
        ];
    }

    public function setNumber(string $number): void
    {
        $number = preg_replace('/[^0-9]/', '', $number);

        if (
            is_null($number) ||
            is_array($number)
        ) {
            return;
        }

        $this
            ->number = $number;

        $this
            ->validateDocument();
    }

    public function setType(): void
    {
        if (strlen($this->number) === 11) {
            $this
                ->type = 'PF';
            return;
        }

        $this
            ->type = 'PJ';
    }

    private function validateDocument(): void
    {
        $documento = $this->number;
        $j = 0;
        for ($i = 0; $i < (strlen($documento)); $i++) {
            if (is_numeric($documento[$i])) {
                $num[$j] = $documento[$i];
                $j++;
            }
        }

        //Etapa 2: Conta os dígitos, um cpf válido possui 11 dígitos numéricos.
        if (count($num) != 11) {
            $isCpfValid = false;
        } else {
            for ($i = 0; $i < 10; $i++) {
                if ($num[0] == $i && $num[1] == $i && $num[2] == $i && $num[3] == $i && $num[4] == $i && $num[5] == $i && $num[6] == $i && $num[7] == $i && $num[8] == $i) {
                    $isCpfValid = false;
                    break;
                }
            }
        }

        //Etapa 4: Calcula e compara o primeiro dígito verificador.
        if (!isset($isCpfValid)) {
            $j = 10;
            for ($i = 0; $i < 9; $i++) {
                $multiplica[$i] = $num[$i] * $j;
                $j--;
            }

            $soma = array_sum($multiplica);

            $resto = $soma % 11;

            if ($resto < 2) {
                $dg = 0;
            } else {
                $dg = 11 - $resto;
            }
            if ($dg != $num[9]) {
                $isCpfValid = false;
            }
        }

        //Etapa 5: Calcula e compara o segundo dígito verificador.
        if (!isset($isCpfValid)) {
            $j = 11;

            for ($i = 0; $i < 10; $i++) {
                $multiplica[$i] = $num[$i] * $j;
                $j--;
            }
            $soma = array_sum($multiplica);

            $resto = $soma % 11;

            if ($resto < 2) {
                $dg = 0;
            } else {
                $dg = 11 - $resto;
            }

            if ($dg != $num[10]) {
                $this->valid = false;
                return;
            } else {
                $this->valid = true;
                return;
            }
        } else {
            $cnpj = $documento;

            // Valida tamanho
            if (strlen($cnpj) != 14) {
                $this->valid = false;
                return;
            }

            // Verifica se todos os digitos são iguais
            if (preg_match('/(\d)\1{13}/', $cnpj)) {
                $this->valid = false;
                return;
            }

            // Valida primeiro dígito verificador
            for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
                $soma += $cnpj[$i] * $j;
                $j = ($j == 2) ? 9 : $j - 1;
            }

            $resto = $soma % 11;

            if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto)) {
                $this->valid = false;
                return;
            }

            // Valida segundo dígito verificador
            for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
                $soma += $cnpj[$i] * $j;
                $j = ($j == 2) ? 9 : $j - 1;
            }

            $this->valid = true;
        }
    }
}

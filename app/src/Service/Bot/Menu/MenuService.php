<?php
declare(strict_types = 1);

namespace App\Service\Bot\Menu;

use App\Entity\Team;
use App\Service\Bot\KeyBoard\Button;
use App\Service\Bot\KeyBoard\KeyBoard;
use App\Service\Bot\KeyBoard\Row;

class MenuService
{
    public static function createTeamMenu(array $menuItems): array
    {
        $keyBoard = new KeyBoard();

        $buttons = self::divideButtonsByRows($menuItems, 2);
        $rows    = [];

        foreach ($buttons as $buttonsInRow) {
            $rows[] = (new Row())->add(...$buttonsInRow);
        }

        $keyBoard->add(...$rows);

        return [
            'inline_keyboard' => $keyBoard->toArray(),
            'resize_keyboard' => true,
        ];
    }

    /**
     * распределяет кнопки меню по рядам/строкам меню
     */
    private static function divideButtonsByRows(array $menuItems, int $quantityInRow): array
    {
        $buttons = [];
        $len     = count($menuItems);

        for ($i = 0; $i < $len; $i += $quantityInRow) {
            $menuItemsInRow = array_slice($menuItems, $i, $quantityInRow);
            $buttonsInRow   = [];

            foreach ($menuItemsInRow as $team) {
                /**@var $team Team */
                $buttonsInRow[] = new Button($team->getTitle(), '/' . $team->getSlug());
            }

            $buttons[] = $buttonsInRow;
        }

        return $buttons;
    }
}

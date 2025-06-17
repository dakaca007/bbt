<?php
session_start();

if (!isset($_SESSION['coin'])) $_SESSION['coin'] = 1000;
if (!isset($_SESSION['banker'])) $_SESSION['banker'] = null;

function jinhua_info() {
    $cards = [];
    $deck = [];
    foreach ([1,2,3,4] as $color) {
        foreach (range(2,14) as $brand) {
            $deck[] = "$color-$brand";
        }
    }
    shuffle($deck);
    $cards[] = array_slice($deck, 0, 3);
    $cards[] = array_slice($deck, 3, 3);
    $cards[] = array_slice($deck, 6, 3);
    return $cards;
}

function bet($amount) {
    if ($_SESSION['coin'] < $amount) {
        return "余额不足，无法下注";
    }
    $_SESSION['coin'] -= $amount;
    return "下注成功，当前余额：" . $_SESSION['coin'];
}

function settle($win = false, $amount = 0) {
    if ($win) {
        $_SESSION['coin'] += $amount;
        return "结算成功，赢得 $amount，当前余额：" . $_SESSION['coin'];
    } else {
        return "结算完成，未中奖，当前余额：" . $_SESSION['coin'];
    }
}

function set_banker($deposit) {
    if ($_SESSION['coin'] < $deposit) {
        return "押金不足，无法上庄";
    }
    $_SESSION['coin'] -= $deposit;
    $_SESSION['banker'] = $deposit;
    return "上庄成功，押金 $deposit，当前余额：" . $_SESSION['coin'];
}

function quit_banker() {
    if ($_SESSION['banker']) {
        $_SESSION['coin'] += $_SESSION['banker'];
        $_SESSION['banker'] = null;
        return "下庄成功，返还押金，当前余额：" . $_SESSION['coin'];
    }
    return "你不是庄家";
}
<?php
session_start();

if (!isset($_SESSION['coin'])) $_SESSION['coin'] = 1000;
if (!isset($_SESSION['banker'])) $_SESSION['banker'] = null;

function get_user_coin($conn, $user_id) {
    $stmt = $conn->prepare("SELECT coin FROM users WHERE id=?");
    $stmt->execute([$user_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ? intval($row['coin']) : 0;
}

function set_user_coin($conn, $user_id, $coin) {
    $stmt = $conn->prepare("UPDATE users SET coin=? WHERE id=?");
    $stmt->execute([$coin, $user_id]);
}

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

function bet($conn, $user_id, $amount) {
    $coin = get_user_coin($conn, $user_id);
    if ($coin < $amount) {
        return "余额不足，无法下注";
    }
    $coin -= $amount;
    set_user_coin($conn, $user_id, $coin);
    $_SESSION['user']['coin'] = $coin;
    return "下注成功，当前余额：" . $coin;
}

function settle($conn, $user_id, $win = false, $amount = 0) {
    $coin = get_user_coin($conn, $user_id);
    if ($win) {
        $coin += $amount;
        set_user_coin($conn, $user_id, $coin);
        $_SESSION['user']['coin'] = $coin;
        return "结算成功，赢得 $amount，当前余额：" . $coin;
    } else {
        return "结算完成，未中奖，当前余额：" . $coin;
    }
}

function set_banker($conn, $user_id, $deposit) {
    $coin = get_user_coin($conn, $user_id);
    if ($coin < $deposit) {
        return "押金不足，无法上庄";
    }
    $coin -= $deposit;
    set_user_coin($conn, $user_id, $coin);
    $_SESSION['user']['coin'] = $coin;
    $_SESSION['banker'] = $deposit;
    return "上庄成功，押金 $deposit，当前余额：" . $coin;
}

function quit_banker($conn, $user_id) {
    if (isset($_SESSION['banker']) && $_SESSION['banker']) {
        $coin = get_user_coin($conn, $user_id);
        $coin += $_SESSION['banker'];
        set_user_coin($conn, $user_id, $coin);
        $_SESSION['user']['coin'] = $coin;
        $_SESSION['banker'] = null;
        return "下庄成功，返还押金，当前余额：" . $coin;
    }
    return "你不是庄家";
}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.6/underscore-min.js" integrity="sha512-2V49R8ndaagCOnwmj8QnbT1Gz/rie17UouD9Re5WxbzRVUGoftCu5IuqqtAM9+UC3fwfHCSJR1hkzNQh/2wdtg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.1/backbone.js" integrity="sha512-cVCKajVEnGO1bx8ff7iIy2Ffv6u6F/epjJxuNXGgNmFPYOMby8/hjBwMMf/qepsDGYz1uoiGcuDRfYmfVBzJFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/styles.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/questionStyle.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/login.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/register.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/flashy.min.css">
    <title>Tech Quiz</title>
</head>
<body>
    <section>
        <header>
            <a href="<?php echo base_url(); ?>home"><img src="<?php echo base_url(); ?>assets/images/logo.jpg" class="logo" > </a>
            <ul class="navigation">
                <li id="homeTab"><a href="<?php echo base_url(); ?>">Home</a></li>
                <li id="aboutTab"><a href="<?php echo base_url(); ?>index.php/about">About</a></li>
                <li id="contactTab"><a href="<?php echo base_url(); ?>contact">Contact</a></li>
                <li id="questionTab"><a href="<?php echo base_url(); ?>questions">Questions</a></li>
                <li id="loginTab"><a href="<?php echo base_url(); ?>users/login">Login</a></li>
                <li id="registerTab"><a href="<?php echo base_url(); ?>users/login#/register">Register</a></li>
                <li id="logoutTab"><a href="">Logout</a></li>
            </ul>
        </header>
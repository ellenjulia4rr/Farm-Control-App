<?php

class AppKernel
{
    public function registerBundles()
    {
        return [

            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),

        ];
    }
}
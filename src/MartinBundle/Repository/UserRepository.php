<?php

namespace MartinBundle\Repository;

use Symfony\Component\DependencyInjection\ContainerInterface;

class UserRepository
{
    protected $container;
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
/*
//Oprócz metody fetchAssoc, klasa Doctrine\DBAL\Connection dostarcza również następujące metody do pobierania danych z bazy danych:

// * fetchAssoc: zwraca wynik jako tablice associatywnych danych z bazy danych
// * fetchArray: zwraca wynik jako indeksowany numerycznie tablicę asocjacyjną
// * fetchColumn: zwraca pierwszą wartość pierwszego wiersza wyniku
// * fetchAll: zwraca tablicę zawierającą wszystkie wiersze wyniku jako tablice asocjacyjne
// * fetchObject: zwraca pierwszy wiersz wyniku jako obiekt klasy określonej przez drugi argument metody
// * fetchAllKeyValue: zwraca tablicę zawierającą klucze i wartości wyniku, gdzie pierwsza kolumna wyniku jest kluczem, a druga kolumna jest wartością
// * Można również użyć metody executeQuery do wykonania zapytania i uzyskania obiektu Doctrine\DBAL\Driver\ResultStatement,
// który zawiera wynik zapytania. Następnie można użyć różnych metod tego obiektu do pobierania danych.
//
*/
    public function findOneUser(int $id)
    {
        $connection = $this->container->get('database_connection');

        $sql = 'SELECT * FROM user WHERE id = ?';
        $user = $connection->fetchAssoc($sql, array($id));

        return $user;
    }

    public function findAllUser()
    {
        $connection = $this->container->get('database_connection');
        $sql = 'SELECT * FROM user';
        $user = $connection->fetchAll($sql);

        return $user;
    }

    public function addUser(string $name, string $email){
        $connection = $this->container->get('database_connection');

        // sprawdź, czy podany adres e-mail już istnieje w bazie
        $existingUser = $connection->fetchAssoc('SELECT * FROM user WHERE email = ?', array($email));
        if ($existingUser) {
            return 'E-mail address already exists';
        }

        // dodaj nowego użytkownika do bazy
        $sql = 'INSERT INTO user (name, email) VALUES (?, ?)';
        $connection->executeUpdate($sql, array($name, $email));

        return 'User added successfully';
    }
}
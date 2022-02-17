<?php

namespace App\Enums;

enum UserRoles: string {
   case SuperAdmin = 'super-admin';
   case Admin = 'admin';
   case Supervisor = 'supervisor';
   case Workforce = 'workforce';
   case User = 'user';
   case Guest = 'guest';
   case Customer = 'customer';
}

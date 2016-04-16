<?php
/**
 * Created by PhpStorm.
 * User: yanni
 * Date: 06.03.2016
 * Time: 21:19
 */

namespace Entrance;

define("PERM_DB_LOGIN", "admin.database");
define("PERM_ADMIN_ERRORS", "admin.errors");
define("PERM_ADMIN_TRACING", "admin.tracing");
define("PERM_ADMIN_NOTIFY", "admin.notify");
define("PERM_ADMIN_NOTIFY_RECEIVE", "admin.notify.receive");
define("PERM_ADMIN_KICKALL", "admin.kickall");
define("PERM_ADMIN_EXPORT", "admin.export");
define("PERM_ADMIN_STATE_CLOSE", "admin.state.close");
define("PERM_ADMIN_STATE_OPEN", "admin.state.open");
define("PERM_ADMIN_STATE_DASHBOARD", "admin.state.dashboard");

define("PERM_USER_DELETE", "users.del");
define("PERM_USER_EDIT",   "users.edit");
define("PERM_USER_CREATE", "users.create");
define("PERM_USER_VIEW", "users.view");
define("PERM_USER_EDIT_PERMISSIONS", "users.perms");
define("PERM_USER_GUARDCONTROL", "users.guardcontrol");

define("PERM_CITIZEN_LOGIN", "citizen.login");
define("PERM_CITIZEN_LOGOUT", "citizen.logout");
define("PERM_CITIZEN_CORRECT_ERRORS", "citizen.correcterrors");
define("PERM_CITIZEN_IGNORE_ERRORS", "citizen.ignoreerrors");
define("PERM_CITIZEN_PRESENT_NUMBER", "citizen.present.number");
define("PERM_CITIZEN_PRESENT_LIST", "citizen.present.list");
define("PERM_CITIZEN_INFO_SPECIFIC", "citizen.info.specific");
define("PERM_CITIZEN_INFO_DIFFERENCE", "citizen.info.difference");

define("PERM_CITIZEN_DELETE", "citizen.del");
define("PERM_CITIZEN_EDIT",   "citizen.edit");
define("PERM_CITIZEN_CREATE", "citizen.create");
define("PERM_CITIZEN_VIEW", "citizen.view");

define("PERM_TRACING_ADD", "citizen.tracing.add");
define("PERM_TRACING_REMOVE", "citizen.tracing.remove");
define("PERM_TRACING_LIST", "citizen.tracing.list");
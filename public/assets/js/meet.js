import PermissionQuery from "./class/permissions/permision-query.js";

class MeetLoader {
    async loadPermissions() {
        (await new PermissionQuery().getPermission()).configureGrantedHandlers();
    }
}

// Create a instance
const meetLoader = new MeetLoader();

// Load permissions
meetLoader.loadPermissions();

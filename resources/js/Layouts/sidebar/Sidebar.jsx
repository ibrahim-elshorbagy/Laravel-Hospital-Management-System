import SidebarDisplay from "@/Components/SidebarDisplay";
import { FaTachometerAlt, FaUser, FaCog } from "react-icons/fa";
const Sidebar = () => {
    const sections = [
        {
            title: "Dashboard",
            links: [
                { text: "Manage Accounts", href: "/", icon: FaUser },
                { text: "Settings", href: "/", icon: FaCog },
            ],
            icon: FaTachometerAlt,
        },
    ];
    return <SidebarDisplay sections={sections} />;
};

export default Sidebar;



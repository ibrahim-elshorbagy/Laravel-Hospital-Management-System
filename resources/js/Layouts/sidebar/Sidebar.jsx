import SidebarDisplay from "@/Components/SidebarDisplay";
import {
    FaTachometerAlt,
    FaUserInjured,
    FaUserMd,
    FaCalendarCheck,
    FaFileMedical,
    FaFileInvoiceDollar,
    FaPills,
    FaMicroscope,
    FaXRay,
    FaCog,
    FaHospital,
    FaHandHoldingMedical,
} from "react-icons/fa";

import { MdMedicalServices } from "react-icons/md";

const Sidebar = ({ user }) => {
    const sections = [
        //receptionist
        {
            title: "Dashboard",
            links: [
                {
                    text: "Home",
                    href: "dashboard",
                    icon: FaTachometerAlt,
                    roles: ["admin", "patient", "receptionist", "doctor"],
                },
                {
                    text: "Clinics",
                    href: "clinic.index",
                    icon: FaHospital,
                    roles: ["admin"],
                },
            ],
            icon: FaTachometerAlt,
            roles: ["admin", "patient", "receptionist", "doctor"],
        },
        {
            title: "Accounting",
            links: [
                {
                    text: "Invoices",
                    href: "invoice.index",
                    icon: FaFileInvoiceDollar,
                    roles: ["admin", "receptionist"],
                },
            ],
            icon: FaFileInvoiceDollar,
            roles: ["admin", "receptionist"],
        },

        //Admin

        {
            title: "Doctors",
            links: [
                {
                    text: "All Doctors",
                    href: "doctor.index",
                    icon: FaUserMd,
                    roles: ["admin"],
                },
            ],
            icon: FaUserMd,
            roles: ["admin"],
        },
        {
            title: "Services",
            links: [
                {
                    text: "Services",
                    href: "service.index",
                    icon: FaHandHoldingMedical,
                    roles: ["admin"],
                },
                {
                    text: "Packages",
                    href: "package.index",
                    icon: MdMedicalServices,
                    roles: ["admin"],
                },
            ],
            icon: FaHandHoldingMedical,
            roles: ["admin"],
        },
        {
            title: "Patients",
            links: [
                {
                    text: "Patients",
                    href: "patient.index",
                    icon: FaUserInjured,
                    roles: ["admin"],
                },
            ],
            icon: FaUserInjured,
            roles: ["admin"],
        },

        //patient
        {
            title: "My Invoices",
            links: [
                {
                    text: "my-invoice",
                    href: "my-invoice",
                    icon: FaFileInvoiceDollar,
                    roles: ["patient"],
                },
            ],
            icon: FaFileInvoiceDollar,
            roles: ["patient"],
        },
        //doctor
        {
            title: "Patients",
            links: [
                {
                    text: "My Patients",
                    href: "doc.my-patient",
                    icon: FaUserInjured,
                    roles: ["doctor"],
                },
            ],
            icon: FaUserInjured,
            roles: ["doctor"],
        },

        {
            title: "Appointments",
            links: [
                {
                    text: "Manage Appointments",
                    href: "dashboard.index",
                    icon: FaCalendarCheck,
                    roles: ["admin"],
                },
            ],
            icon: FaCalendarCheck,
            roles: ["admin"],
        },
        {
            title: "Medical Records",
            links: [
                {
                    text: "Records",
                    href: "dashboard.index",
                    icon: FaFileMedical,
                    roles: ["admin", "nurse"],
                },
            ],
            icon: FaFileMedical,
            roles: ["admin", "nurse"],
        },
        {
            title: "Pharmacy",
            links: [
                {
                    text: "Medicines",
                    href: "dashboard.index",
                    icon: FaPills,
                    roles: ["admin", "pharmacist"],
                },
            ],
            icon: FaPills,
            roles: ["admin", "pharmacist"],
        },
        {
            title: "Laboratory",
            links: [
                {
                    text: "Tests",
                    href: "dashboard.index",
                    icon: FaMicroscope,
                    roles: ["admin", "lab_technician"],
                },
            ],
            icon: FaMicroscope,
            roles: ["admin", "lab_technician"],
        },
        {
            title: "Radiology",
            links: [
                {
                    text: "Imaging",
                    href: "dashboard.index",
                    icon: FaXRay,
                    roles: ["admin", "radiologist"],
                },
            ],
            icon: FaXRay,
            roles: ["admin", "radiologist"],
        },
        {
            title: "Settings",
            links: [
                {
                    text: "General Settings",
                    href: "dashboard.index",
                    icon: FaCog,
                    roles: ["admin"],
                },
            ],
            icon: FaCog,
            roles: ["admin"],
        },
    ];

    // Filter sections and links based on user roles
    const filteredSections = sections
        .map((section) => ({
            ...section,
            links: section.links.filter((link) =>
                link.roles.some((role) => user.roles.includes(role))
            ),
        }))
        .filter(
            (section) =>
                section.roles.some((role) => user.roles.includes(role)) &&
                section.links.length > 0
        );

    return <SidebarDisplay sections={filteredSections} />;
};

export default Sidebar;

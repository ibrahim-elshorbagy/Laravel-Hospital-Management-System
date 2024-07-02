import { Link } from "@inertiajs/react";
import React, { useState } from "react";
import { FaChevronDown, FaChevronUp } from "react-icons/fa";

const SidebarSection = ({ title, subtitle, links, icon: SectionIcon }) => {
    const [isOpen, setIsOpen] = useState(false);

    return (
        <div>
            <button
                onClick={() => setIsOpen(!isOpen)}
                className="flex items-center justify-between w-full px-6 py-3 text-gray-400 cursor-pointer hover:bg-gray-700 hover:text-gray-200 focus:outline-none"
            >
                <span className="flex items-center">
                    {SectionIcon && <SectionIcon className="w-5 h-5" />}
                    <span className="mx-4 font-medium">{title}</span>
                </span>
                {subtitle && (
                    <span className="mx-2 text-sm text-gray-500">
                        {subtitle}
                    </span>
                )}
                <span>
                    {isOpen ? (
                        <FaChevronUp className="w-4 h-4" />
                    ) : (
                        <FaChevronDown className="w-4 h-4" />
                    )}
                </span>
            </button>
            {isOpen && (
                <div className="bg-gray-800">
                    {links.map((link, index) => (
                        <Link
                            key={index}
                            className="flex items-center px-8 py-2 text-sm text-gray-400 hover:bg-blue-500 hover:text-white"
                            href={route(link.href)}
                        >
                            {link.icon && (
                                <link.icon className="w-4 h-4 mr-2" />
                            )}{" "}
                            {link.text}
                        </Link>
                    ))}
                </div>
            )}
        </div>
    );
};

const SidebarDisplay = ({ sections = [] }) => {
    return (
        <div className="flex flex-col sm:flex-row sm:justify-around">
            <div className="w-64 h-screen bg-gray-800">
                <nav className="mt-10">
                    {sections.map((section, index) => (
                        <SidebarSection
                            key={index}
                            title={section.title}
                            subtitle={section.subtitle}
                            links={section.links}
                            icon={section.icon}
                        />
                    ))}
                </nav>
            </div>
        </div>
    );
};

export default SidebarDisplay;

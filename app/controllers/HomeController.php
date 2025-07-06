<?php
/**
 * Controlador para la página principal (Home)
 * Maneja la vista de bienvenida del sistema
 */

require_once 'app/controllers/BaseController.php';

class HomeController extends BaseController {
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Página principal - Vista de bienvenida
     */
    public function index() {
        // Datos para la vista
        $data = [
            'title' => 'SUNOBRA - Construyelo con tus manos',
            'description' => 'Sistema de gestión de servicios de construcción',
            'company_name' => 'SUNOBRA',
            'slogan' => 'Construyelo con tus manos',
            'contact_info' => [
                'email' => 'sunobra69@gmail.com',
                'phone' => '3138385779',
                'location' => 'Bogota Colombia'
            ],
            'social_media' => [
                'instagram' => 'https://instagram.com/sunobra',
                'facebook' => 'https://facebook.com/sunobra',
                'twitter' => 'https://twitter.com/sunobra'
            ],
            'team_members' => [
                [
                    'name' => 'David Torres',
                    'role' => 'Fundador',
                    'image' => 'assets/imgs/gallary-1.jpg',
                    'description' => 'Experto en construcción y gestión de proyectos.'
                ],
                [
                    'name' => 'Felipe Bermudez',
                    'role' => 'Director Técnico',
                    'image' => 'assets/imgs/gallary-2.jpg',
                    'description' => 'Especialista en planificación y ejecución de obras.'
                ],
                [
                    'name' => 'Dilan Ruiz',
                    'role' => 'Gerente de Operaciones',
                    'image' => 'assets/imgs/gallary-3.jpg',
                    'description' => 'Responsable de la coordinación de equipos y recursos.'
                ]
            ],
            'projects' => [
                [
                    'title' => 'Proyecto Residencial',
                    'image' => 'assets/imgs/gallary-1.jpg',
                    'description' => 'Construcción de viviendas modernas'
                ],
                [
                    'title' => 'Edificio Comercial',
                    'image' => 'assets/imgs/gallary-2.jpg',
                    'description' => 'Centro comercial de 3 pisos'
                ],
                [
                    'title' => 'Obra Civil',
                    'image' => 'assets/imgs/gallary-3.jpg',
                    'description' => 'Infraestructura vial y puentes'
                ],
                [
                    'title' => 'Renovación',
                    'image' => 'assets/imgs/gallary-1.jpg',
                    'description' => 'Remodelación de espacios comerciales'
                ],
                [
                    'title' => 'Proyecto Industrial',
                    'image' => 'assets/imgs/gallary-2.jpg',
                    'description' => 'Nave industrial de 2000m²'
                ],
                [
                    'title' => 'Urbanización',
                    'image' => 'assets/imgs/gallary-3.jpg',
                    'description' => 'Desarrollo urbano integral'
                ]
            ]
        ];
        
        // Renderizar la vista
        $this->render('home', $data);
    }
    
    /**
     * Página de contacto
     */
    public function contact() {
        $data = [
            'title' => 'Contacto - SUNOBRA',
            'contact_info' => [
                'email' => 'sunobra69@gmail.com',
                'phone' => '3138385779',
                'location' => 'Bogota Colombia',
                'address' => 'Calle Principal #123, Bogotá, Colombia'
            ],
            'business_hours' => [
                'Lunes - Viernes' => '8:00 AM - 6:00 PM',
                'Sábados' => '8:00 AM - 2:00 PM',
                'Domingos' => 'Cerrado'
            ]
        ];
        
        $this->render('contact', $data);
    }
    
    /**
     * Página sobre nosotros
     */
    public function about() {
        $data = [
            'title' => 'Sobre Nosotros - SUNOBRA',
            'company_info' => [
                'name' => 'SUNOBRA',
                'founded' => '2020',
                'mission' => 'Proporcionar servicios de construcción de alta calidad con un enfoque en la innovación y la sostenibilidad.',
                'vision' => 'Ser líderes en el sector de la construcción, reconocidos por la excelencia en nuestros proyectos y el compromiso con nuestros clientes.',
                'values' => [
                    'Calidad',
                    'Innovación',
                    'Responsabilidad',
                    'Transparencia',
                    'Compromiso'
                ]
            ],
            'team' => [
                [
                    'name' => 'David Torres',
                    'position' => 'CEO & Fundador',
                    'experience' => '15 años en construcción',
                    'specialties' => ['Gestión de proyectos', 'Desarrollo inmobiliario']
                ],
                [
                    'name' => 'Felipe Bermudez',
                    'position' => 'Director Técnico',
                    'experience' => '12 años en ingeniería',
                    'specialties' => ['Planificación', 'Control de calidad']
                ],
                [
                    'name' => 'Dilan Ruiz',
                    'position' => 'Gerente de Operaciones',
                    'experience' => '10 años en gestión',
                    'specialties' => ['Logística', 'Coordinación de equipos']
                ]
            ]
        ];
        
        $this->render('about', $data);
    }
    
    /**
     * Página de servicios
     */
    public function services() {
        $data = [
            'title' => 'Servicios - SUNOBRA',
            'services' => [
                [
                    'name' => 'Construcción Residencial',
                    'description' => 'Construcción de viviendas unifamiliares y multifamiliares',
                    'icon' => 'fas fa-home',
                    'features' => [
                        'Diseño personalizado',
                        'Materiales de calidad',
                        'Supervisión profesional',
                        'Garantía de obra'
                    ]
                ],
                [
                    'name' => 'Construcción Comercial',
                    'description' => 'Edificios comerciales, oficinas y espacios comerciales',
                    'icon' => 'fas fa-building',
                    'features' => [
                        'Diseño funcional',
                        'Optimización de espacios',
                        'Cumplimiento normativo',
                        'Entrega a tiempo'
                    ]
                ],
                [
                    'name' => 'Obra Civil',
                    'description' => 'Infraestructura vial, puentes y obras públicas',
                    'icon' => 'fas fa-road',
                    'features' => [
                        'Ingeniería especializada',
                        'Materiales certificados',
                        'Control de calidad',
                        'Mantenimiento'
                    ]
                ],
                [
                    'name' => 'Renovación y Remodelación',
                    'description' => 'Actualización y mejora de espacios existentes',
                    'icon' => 'fas fa-tools',
                    'features' => [
                        'Evaluación previa',
                        'Diseño de mejora',
                        'Ejecución eficiente',
                        'Minimización de interrupciones'
                    ]
                ]
            ]
        ];
        
        $this->render('services', $data);
    }
    
    /**
     * Página de proyectos
     */
    public function projects() {
        $data = [
            'title' => 'Proyectos - SUNOBRA',
            'projects' => [
                [
                    'title' => 'Residencial Los Pinos',
                    'category' => 'Residencial',
                    'location' => 'Bogotá, Colombia',
                    'area' => '2,500 m²',
                    'duration' => '18 meses',
                    'description' => 'Conjunto residencial de 50 apartamentos con amenidades completas.',
                    'image' => 'assets/imgs/gallary-1.jpg',
                    'status' => 'Completado'
                ],
                [
                    'title' => 'Centro Comercial Plaza Central',
                    'category' => 'Comercial',
                    'location' => 'Medellín, Colombia',
                    'area' => '15,000 m²',
                    'duration' => '24 meses',
                    'description' => 'Centro comercial de 3 pisos con 100 locales comerciales.',
                    'image' => 'assets/imgs/gallary-2.jpg',
                    'status' => 'En construcción'
                ],
                [
                    'title' => 'Puente La Esperanza',
                    'category' => 'Obra Civil',
                    'location' => 'Cali, Colombia',
                    'area' => '500 m',
                    'duration' => '12 meses',
                    'description' => 'Puente vehicular de 500 metros sobre el río Cauca.',
                    'image' => 'assets/imgs/gallary-3.jpg',
                    'status' => 'Completado'
                ]
            ]
        ];
        
        $this->render('projects', $data);
    }
    
    /**
     * Procesar formulario de contacto
     */
    public function sendContact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar datos del formulario
            $name = $this->sanitize($_POST['name'] ?? '');
            $email = $this->sanitize($_POST['email'] ?? '');
            $subject = $this->sanitize($_POST['subject'] ?? '');
            $message = $this->sanitize($_POST['message'] ?? '');
            
            $errors = [];
            
            if (empty($name)) {
                $errors[] = 'El nombre es requerido';
            }
            
            if (empty($email) || !$this->validateEmail($email)) {
                $errors[] = 'El email es requerido y debe ser válido';
            }
            
            if (empty($subject)) {
                $errors[] = 'El asunto es requerido';
            }
            
            if (empty($message)) {
                $errors[] = 'El mensaje es requerido';
            }
            
            if (empty($errors)) {
                // Aquí se procesaría el envío del email
                // Por ahora solo simulamos el éxito
                $this->setFlash('success', 'Mensaje enviado correctamente. Nos pondremos en contacto contigo pronto.');
                $this->redirect('home/contact');
            } else {
                $this->setFlash('error', implode(', ', $errors));
                $this->redirect('home/contact');
            }
        } else {
            $this->redirect('home');
        }
    }
    
    /**
     * Página de política de privacidad
     */
    public function privacy() {
        $data = [
            'title' => 'Política de Privacidad - SUNOBRA',
            'last_updated' => '2024-01-15'
        ];
        
        $this->render('privacy', $data);
    }
    
    /**
     * Página de términos y condiciones
     */
    public function terms() {
        $data = [
            'title' => 'Términos y Condiciones - SUNOBRA',
            'last_updated' => '2024-01-15'
        ];
        
        $this->render('terms', $data);
    }
}
?> 
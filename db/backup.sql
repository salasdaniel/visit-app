--
-- PostgreSQL database dump
--

-- Dumped from database version 12.16
-- Dumped by pg_dump version 12.16

-- Started on 2025-08-10 21:44:21

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 214 (class 1255 OID 40977)
-- Name: set_updated_at(); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION public.set_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
  NEW.updated_at = NOW();
  RETURN NEW;
END;
$$;


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 203 (class 1259 OID 24588)
-- Name: customers; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.customers (
    id integer NOT NULL,
    first_name character varying(45) NOT NULL,
    last_name character varying(45) NOT NULL,
    tax_id character varying(45),
    address character varying(500),
    subscription_plan character varying(45),
    notes character varying(100),
    trial_code character(1),
    is_active boolean DEFAULT true NOT NULL,
    phone character varying(45),
    visit_day character varying(45),
    visit_time character varying(45),
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone DEFAULT now()
);


--
-- TOC entry 202 (class 1259 OID 24586)
-- Name: clientes_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.clientes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2905 (class 0 OID 0)
-- Dependencies: 202
-- Name: clientes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.clientes_id_seq OWNED BY public.customers.id;


--
-- TOC entry 207 (class 1259 OID 24610)
-- Name: users; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.users (
    id integer NOT NULL,
    first_name character varying(45) NOT NULL,
    last_name character varying(45) NOT NULL,
    document_number bigint NOT NULL,
    role integer NOT NULL,
    trial954 character(1),
    is_active boolean DEFAULT true NOT NULL,
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone DEFAULT now()
);


--
-- TOC entry 206 (class 1259 OID 24608)
-- Name: personas_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.personas_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2906 (class 0 OID 0)
-- Dependencies: 206
-- Name: personas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.personas_id_seq OWNED BY public.users.id;


--
-- TOC entry 208 (class 1259 OID 24623)
-- Name: plans; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.plans (
    id integer NOT NULL,
    name character varying(45) NOT NULL,
    description character varying(200) NOT NULL,
    trial954 character(1),
    is_active boolean DEFAULT true
);


--
-- TOC entry 209 (class 1259 OID 24634)
-- Name: products; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.products (
    id integer NOT NULL,
    name character varying(100),
    trial954 character(1),
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone DEFAULT now(),
    cost_price bigint DEFAULT 0 NOT NULL,
    sale_price bigint DEFAULT 0 NOT NULL,
    created_user integer,
    is_active boolean DEFAULT true
);


--
-- TOC entry 212 (class 1259 OID 40990)
-- Name: productos_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.productos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2907 (class 0 OID 0)
-- Dependencies: 212
-- Name: productos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.productos_id_seq OWNED BY public.products.id;


--
-- TOC entry 205 (class 1259 OID 24596)
-- Name: roles; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.roles (
    id integer NOT NULL,
    role_name character varying(45) NOT NULL,
    trial954 character(1),
    is_active boolean DEFAULT true
);


--
-- TOC entry 204 (class 1259 OID 24594)
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.roles_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2908 (class 0 OID 0)
-- Dependencies: 204
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;


--
-- TOC entry 211 (class 1259 OID 24647)
-- Name: visits; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.visits (
    id integer NOT NULL,
    customer_id integer NOT NULL,
    advisor_id integer NOT NULL,
    visit_date date NOT NULL,
    check_in_time time without time zone NOT NULL,
    check_out_time time without time zone NOT NULL,
    visit_duration time without time zone NOT NULL,
    needs_water character varying(45) NOT NULL,
    needs_filter character varying(45) NOT NULL,
    needs_chemicals character varying(45) NOT NULL,
    needs_products character varying(45) NOT NULL,
    products character varying(500),
    notes character varying(500),
    image_1 character varying(100),
    image_2 character varying(100),
    image_3 character varying(100),
    image_4 character varying(100),
    trial954 character(1),
    created_at timestamp without time zone DEFAULT now(),
    updated_at timestamp without time zone DEFAULT now()
);


--
-- TOC entry 210 (class 1259 OID 24645)
-- Name: visitas_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.visitas_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2909 (class 0 OID 0)
-- Dependencies: 210
-- Name: visitas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.visitas_id_seq OWNED BY public.visits.id;


--
-- TOC entry 213 (class 1259 OID 49168)
-- Name: vw_visitas; Type: VIEW; Schema: public; Owner: -
--

CREATE VIEW public.vw_visitas AS
 SELECT v.id,
    v.customer_id,
    v.advisor_id,
    v.visit_date,
    v.check_in_time,
    v.check_out_time,
    v.visit_duration,
    v.needs_water,
    v.needs_filter,
    v.needs_products,
    v.products,
    v.notes,
    v.needs_chemicals,
    v.image_1,
    v.image_2,
    v.image_3,
    v.image_4,
    c.first_name AS customer_name,
    c.last_name AS customer_lastname,
    p.first_name AS user_name,
    p.last_name AS user_lastname
   FROM ((public.visits v
     LEFT JOIN public.customers c ON ((v.customer_id = c.id)))
     LEFT JOIN public.users p ON ((v.advisor_id = p.id)));


--
-- TOC entry 2722 (class 2604 OID 24591)
-- Name: customers id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.customers ALTER COLUMN id SET DEFAULT nextval('public.clientes_id_seq'::regclass);


--
-- TOC entry 2738 (class 2604 OID 40992)
-- Name: products id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.products ALTER COLUMN id SET DEFAULT nextval('public.productos_id_seq'::regclass);


--
-- TOC entry 2726 (class 2604 OID 24599)
-- Name: roles id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);


--
-- TOC entry 2728 (class 2604 OID 24613)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.personas_id_seq'::regclass);


--
-- TOC entry 2739 (class 2604 OID 24650)
-- Name: visits id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.visits ALTER COLUMN id SET DEFAULT nextval('public.visitas_id_seq'::regclass);


--
-- TOC entry 2890 (class 0 OID 24588)
-- Dependencies: 203
-- Data for Name: customers; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.customers (id, first_name, last_name, tax_id, address, subscription_plan, notes, trial_code, is_active, phone, visit_day, visit_time, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 2895 (class 0 OID 24623)
-- Dependencies: 208
-- Data for Name: plans; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.plans (id, name, description, trial954, is_active) FROM stdin;
1	gold	2 visits per week	T	t
2	silver	1 visit per week	T	t
3	bronze	1 visit every 15 days	T	t
\.


--
-- TOC entry 2896 (class 0 OID 24634)
-- Dependencies: 209
-- Data for Name: products; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.products (id, name, trial954, created_at, updated_at, cost_price, sale_price, created_user, is_active) FROM stdin;
\.


--
-- TOC entry 2892 (class 0 OID 24596)
-- Dependencies: 205
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.roles (id, role_name, trial954, is_active) FROM stdin;
1	ADMIN	T	t
2	ADVISOR	T	t
\.


--
-- TOC entry 2894 (class 0 OID 24610)
-- Dependencies: 207
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.users (id, first_name, last_name, document_number, role, trial954, is_active, created_at, updated_at) FROM stdin;
53	Admin	User	12345678	1	\N	t	2025-07-30 21:22:33.909391	2025-07-30 21:22:33.909391
54	Advisor	User	87654321	2	\N	t	2025-07-30 21:22:33.909391	2025-07-30 21:22:33.909391
\.


--
-- TOC entry 2898 (class 0 OID 24647)
-- Dependencies: 211
-- Data for Name: visits; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.visits (id, customer_id, advisor_id, visit_date, check_in_time, check_out_time, visit_duration, needs_water, needs_filter, needs_chemicals, needs_products, products, notes, image_1, image_2, image_3, image_4, trial954, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 2910 (class 0 OID 0)
-- Dependencies: 202
-- Name: clientes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.clientes_id_seq', 107, true);


--
-- TOC entry 2911 (class 0 OID 0)
-- Dependencies: 206
-- Name: personas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.personas_id_seq', 54, true);


--
-- TOC entry 2912 (class 0 OID 0)
-- Dependencies: 212
-- Name: productos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.productos_id_seq', 32, true);


--
-- TOC entry 2913 (class 0 OID 0)
-- Dependencies: 204
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.roles_id_seq', 2, true);


--
-- TOC entry 2914 (class 0 OID 0)
-- Dependencies: 210
-- Name: visitas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.visitas_id_seq', 163, true);


--
-- TOC entry 2743 (class 2606 OID 24593)
-- Name: customers pk_clientes; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.customers
    ADD CONSTRAINT pk_clientes PRIMARY KEY (id);


--
-- TOC entry 2747 (class 2606 OID 24621)
-- Name: users pk_personas; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT pk_personas PRIMARY KEY (id);


--
-- TOC entry 2750 (class 2606 OID 24633)
-- Name: plans pk_planes; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.plans
    ADD CONSTRAINT pk_planes PRIMARY KEY (id);


--
-- TOC entry 2752 (class 2606 OID 24644)
-- Name: products pk_productos; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT pk_productos PRIMARY KEY (id);


--
-- TOC entry 2745 (class 2606 OID 24607)
-- Name: roles pk_roles; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT pk_roles PRIMARY KEY (id);


--
-- TOC entry 2755 (class 2606 OID 24667)
-- Name: visits pk_visitas; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.visits
    ADD CONSTRAINT pk_visitas PRIMARY KEY (id);


--
-- TOC entry 2753 (class 1259 OID 24668)
-- Name: cliente_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX cliente_idx ON public.visits USING btree (customer_id);


--
-- TOC entry 2748 (class 1259 OID 24622)
-- Name: roles_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX roles_idx ON public.users USING btree (role);


--
-- TOC entry 2756 (class 1259 OID 24669)
-- Name: vendedor_idx; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX vendedor_idx ON public.visits USING btree (advisor_id);


--
-- TOC entry 2758 (class 2620 OID 40978)
-- Name: customers trigger_update_clientes; Type: TRIGGER; Schema: public; Owner: -
--

CREATE TRIGGER trigger_update_clientes BEFORE UPDATE ON public.customers FOR EACH ROW EXECUTE FUNCTION public.set_updated_at();


--
-- TOC entry 2759 (class 2620 OID 40979)
-- Name: users trigger_update_personas; Type: TRIGGER; Schema: public; Owner: -
--

CREATE TRIGGER trigger_update_personas BEFORE UPDATE ON public.users FOR EACH ROW EXECUTE FUNCTION public.set_updated_at();


--
-- TOC entry 2760 (class 2620 OID 40980)
-- Name: products trigger_update_productos; Type: TRIGGER; Schema: public; Owner: -
--

CREATE TRIGGER trigger_update_productos BEFORE UPDATE ON public.products FOR EACH ROW EXECUTE FUNCTION public.set_updated_at();


--
-- TOC entry 2761 (class 2620 OID 40981)
-- Name: visits trigger_update_visitas; Type: TRIGGER; Schema: public; Owner: -
--

CREATE TRIGGER trigger_update_visitas BEFORE UPDATE ON public.visits FOR EACH ROW EXECUTE FUNCTION public.set_updated_at();


--
-- TOC entry 2757 (class 2606 OID 24693)
-- Name: users roles; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT roles FOREIGN KEY (role) REFERENCES public.roles(id);


-- Completed on 2025-08-10 21:44:22

--
-- PostgreSQL database dump complete
--


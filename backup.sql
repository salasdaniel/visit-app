PGDMP     4                    }            visit_app_dev    12.16    12.16 4    V           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            W           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            X           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            Y           1262    24585    visit_app_dev    DATABASE     �   CREATE DATABASE visit_app_dev WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'English_United States.1252' LC_CTYPE = 'English_United States.1252';
    DROP DATABASE visit_app_dev;
                postgres    false            �            1255    40977    set_updated_at()    FUNCTION     �   CREATE FUNCTION public.set_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
  NEW.updated_at = NOW();
  RETURN NEW;
END;
$$;
 '   DROP FUNCTION public.set_updated_at();
       public          postgres    false            �            1259    24588 	   customers    TABLE     W  CREATE TABLE public.customers (
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
    DROP TABLE public.customers;
       public         heap    postgres    false            �            1259    24586    clientes_id_seq    SEQUENCE     �   CREATE SEQUENCE public.clientes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.clientes_id_seq;
       public          postgres    false    203            Z           0    0    clientes_id_seq    SEQUENCE OWNED BY     D   ALTER SEQUENCE public.clientes_id_seq OWNED BY public.customers.id;
          public          postgres    false    202            �            1259    24610    users    TABLE     �  CREATE TABLE public.users (
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
    DROP TABLE public.users;
       public         heap    postgres    false            �            1259    24608    personas_id_seq    SEQUENCE     �   CREATE SEQUENCE public.personas_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.personas_id_seq;
       public          postgres    false    207            [           0    0    personas_id_seq    SEQUENCE OWNED BY     @   ALTER SEQUENCE public.personas_id_seq OWNED BY public.users.id;
          public          postgres    false    206            �            1259    24623    plans    TABLE     �   CREATE TABLE public.plans (
    id integer NOT NULL,
    name character varying(45) NOT NULL,
    description character varying(200) NOT NULL,
    trial954 character(1),
    is_active boolean DEFAULT true
);
    DROP TABLE public.plans;
       public         heap    postgres    false            �            1259    24634    products    TABLE     |  CREATE TABLE public.products (
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
    DROP TABLE public.products;
       public         heap    postgres    false            �            1259    40990    productos_id_seq    SEQUENCE     y   CREATE SEQUENCE public.productos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.productos_id_seq;
       public          postgres    false    209            \           0    0    productos_id_seq    SEQUENCE OWNED BY     D   ALTER SEQUENCE public.productos_id_seq OWNED BY public.products.id;
          public          postgres    false    212            �            1259    24596    roles    TABLE     �   CREATE TABLE public.roles (
    id integer NOT NULL,
    role_name character varying(45) NOT NULL,
    trial954 character(1),
    is_active boolean DEFAULT true
);
    DROP TABLE public.roles;
       public         heap    postgres    false            �            1259    24594    roles_id_seq    SEQUENCE     �   CREATE SEQUENCE public.roles_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.roles_id_seq;
       public          postgres    false    205            ]           0    0    roles_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;
          public          postgres    false    204            �            1259    24647    visits    TABLE     b  CREATE TABLE public.visits (
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
    DROP TABLE public.visits;
       public         heap    postgres    false            �            1259    24645    visitas_id_seq    SEQUENCE     �   CREATE SEQUENCE public.visitas_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.visitas_id_seq;
       public          postgres    false    211            ^           0    0    visitas_id_seq    SEQUENCE OWNED BY     @   ALTER SEQUENCE public.visitas_id_seq OWNED BY public.visits.id;
          public          postgres    false    210            �            1259    49168 
   vw_visitas    VIEW     q  CREATE VIEW public.vw_visitas AS
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
    DROP VIEW public.vw_visitas;
       public          postgres    false    211    211    211    211    211    207    207    211    211    211    211    211    211    211    211    211    211    211    211    207    203    203    203            �
           2604    24591    customers id    DEFAULT     k   ALTER TABLE ONLY public.customers ALTER COLUMN id SET DEFAULT nextval('public.clientes_id_seq'::regclass);
 ;   ALTER TABLE public.customers ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    203    202    203            �
           2604    40992    products id    DEFAULT     k   ALTER TABLE ONLY public.products ALTER COLUMN id SET DEFAULT nextval('public.productos_id_seq'::regclass);
 :   ALTER TABLE public.products ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    212    209            �
           2604    24599    roles id    DEFAULT     d   ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);
 7   ALTER TABLE public.roles ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    205    204    205            �
           2604    24613    users id    DEFAULT     g   ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.personas_id_seq'::regclass);
 7   ALTER TABLE public.users ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    206    207    207            �
           2604    24650 	   visits id    DEFAULT     g   ALTER TABLE ONLY public.visits ALTER COLUMN id SET DEFAULT nextval('public.visitas_id_seq'::regclass);
 8   ALTER TABLE public.visits ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    210    211    211            J          0    24588 	   customers 
   TABLE DATA           �   COPY public.customers (id, first_name, last_name, tax_id, address, subscription_plan, notes, trial_code, is_active, phone, visit_day, visit_time, created_at, updated_at) FROM stdin;
    public          postgres    false    203   �A       O          0    24623    plans 
   TABLE DATA           K   COPY public.plans (id, name, description, trial954, is_active) FROM stdin;
    public          postgres    false    208   	B       P          0    24634    products 
   TABLE DATA              COPY public.products (id, name, trial954, created_at, updated_at, cost_price, sale_price, created_user, is_active) FROM stdin;
    public          postgres    false    209   hB       L          0    24596    roles 
   TABLE DATA           C   COPY public.roles (id, role_name, trial954, is_active) FROM stdin;
    public          postgres    false    205   �B       N          0    24610    users 
   TABLE DATA           ~   COPY public.users (id, first_name, last_name, document_number, role, trial954, is_active, created_at, updated_at) FROM stdin;
    public          postgres    false    207   �B       R          0    24647    visits 
   TABLE DATA             COPY public.visits (id, customer_id, advisor_id, visit_date, check_in_time, check_out_time, visit_duration, needs_water, needs_filter, needs_chemicals, needs_products, products, notes, image_1, image_2, image_3, image_4, trial954, created_at, updated_at) FROM stdin;
    public          postgres    false    211   &C       _           0    0    clientes_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.clientes_id_seq', 107, true);
          public          postgres    false    202            `           0    0    personas_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.personas_id_seq', 54, true);
          public          postgres    false    206            a           0    0    productos_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.productos_id_seq', 32, true);
          public          postgres    false    212            b           0    0    roles_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('public.roles_id_seq', 2, true);
          public          postgres    false    204            c           0    0    visitas_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.visitas_id_seq', 163, true);
          public          postgres    false    210            �
           2606    24593    customers pk_clientes 
   CONSTRAINT     S   ALTER TABLE ONLY public.customers
    ADD CONSTRAINT pk_clientes PRIMARY KEY (id);
 ?   ALTER TABLE ONLY public.customers DROP CONSTRAINT pk_clientes;
       public            postgres    false    203            �
           2606    24621    users pk_personas 
   CONSTRAINT     O   ALTER TABLE ONLY public.users
    ADD CONSTRAINT pk_personas PRIMARY KEY (id);
 ;   ALTER TABLE ONLY public.users DROP CONSTRAINT pk_personas;
       public            postgres    false    207            �
           2606    24633    plans pk_planes 
   CONSTRAINT     M   ALTER TABLE ONLY public.plans
    ADD CONSTRAINT pk_planes PRIMARY KEY (id);
 9   ALTER TABLE ONLY public.plans DROP CONSTRAINT pk_planes;
       public            postgres    false    208            �
           2606    24644    products pk_productos 
   CONSTRAINT     S   ALTER TABLE ONLY public.products
    ADD CONSTRAINT pk_productos PRIMARY KEY (id);
 ?   ALTER TABLE ONLY public.products DROP CONSTRAINT pk_productos;
       public            postgres    false    209            �
           2606    24607    roles pk_roles 
   CONSTRAINT     L   ALTER TABLE ONLY public.roles
    ADD CONSTRAINT pk_roles PRIMARY KEY (id);
 8   ALTER TABLE ONLY public.roles DROP CONSTRAINT pk_roles;
       public            postgres    false    205            �
           2606    24667    visits pk_visitas 
   CONSTRAINT     O   ALTER TABLE ONLY public.visits
    ADD CONSTRAINT pk_visitas PRIMARY KEY (id);
 ;   ALTER TABLE ONLY public.visits DROP CONSTRAINT pk_visitas;
       public            postgres    false    211            �
           1259    24668    cliente_idx    INDEX     E   CREATE INDEX cliente_idx ON public.visits USING btree (customer_id);
    DROP INDEX public.cliente_idx;
       public            postgres    false    211            �
           1259    24622 	   roles_idx    INDEX     ;   CREATE INDEX roles_idx ON public.users USING btree (role);
    DROP INDEX public.roles_idx;
       public            postgres    false    207            �
           1259    24669    vendedor_idx    INDEX     E   CREATE INDEX vendedor_idx ON public.visits USING btree (advisor_id);
     DROP INDEX public.vendedor_idx;
       public            postgres    false    211            �
           2620    40978 !   customers trigger_update_clientes    TRIGGER     �   CREATE TRIGGER trigger_update_clientes BEFORE UPDATE ON public.customers FOR EACH ROW EXECUTE FUNCTION public.set_updated_at();
 :   DROP TRIGGER trigger_update_clientes ON public.customers;
       public          postgres    false    203    214            �
           2620    40979    users trigger_update_personas    TRIGGER     |   CREATE TRIGGER trigger_update_personas BEFORE UPDATE ON public.users FOR EACH ROW EXECUTE FUNCTION public.set_updated_at();
 6   DROP TRIGGER trigger_update_personas ON public.users;
       public          postgres    false    214    207            �
           2620    40980 !   products trigger_update_productos    TRIGGER     �   CREATE TRIGGER trigger_update_productos BEFORE UPDATE ON public.products FOR EACH ROW EXECUTE FUNCTION public.set_updated_at();
 :   DROP TRIGGER trigger_update_productos ON public.products;
       public          postgres    false    209    214            �
           2620    40981    visits trigger_update_visitas    TRIGGER     |   CREATE TRIGGER trigger_update_visitas BEFORE UPDATE ON public.visits FOR EACH ROW EXECUTE FUNCTION public.set_updated_at();
 6   DROP TRIGGER trigger_update_visitas ON public.visits;
       public          postgres    false    211    214            �
           2606    24693    users roles    FK CONSTRAINT     g   ALTER TABLE ONLY public.users
    ADD CONSTRAINT roles FOREIGN KEY (role) REFERENCES public.roles(id);
 5   ALTER TABLE ONLY public.users DROP CONSTRAINT roles;
       public          postgres    false    2745    205    207            J      x������ � �      O   O   x�3�L��I�4R(�,�,)V(H-R(OM���,�2�,��)K-�4�H��s&��U��eS�J+MR+��Jb���� I�      P      x������ � �      L   "   x�3�tt�����,�2��<�����=... k�g      N   _   x�35�tL����-N-�4426153��4���,�4202�50�56P02�22�26ֳ4�4�4�#�ej4�,�8�b�������P%���qqq 	�$p      R      x������ � �     
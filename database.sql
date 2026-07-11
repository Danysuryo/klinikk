--
-- PostgreSQL database dump
--

\restrict 8P0kNWaqofh35TiNLEkly3Y0DqvjuMbAApzepHdgBBzpOfcGRsGbBcDVuRIv3pv

-- Dumped from database version 18.3
-- Dumped by pg_dump version 18.3

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: dokter; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.dokter (
    id_dokter integer NOT NULL,
    nama_dokter character varying(100) NOT NULL,
    spesialisasi character varying(100),
    nomor_telepon character varying(20)
);


ALTER TABLE public.dokter OWNER TO postgres;

--
-- Name: dokter_id_dokter_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.dokter_id_dokter_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.dokter_id_dokter_seq OWNER TO postgres;

--
-- Name: dokter_id_dokter_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.dokter_id_dokter_seq OWNED BY public.dokter.id_dokter;


--
-- Name: janji_temu; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.janji_temu (
    id_janji_temu integer NOT NULL,
    id_pasien integer NOT NULL,
    id_dokter integer NOT NULL,
    tanggal_janji date NOT NULL,
    keluhan text,
    status character varying(20) DEFAULT 'Menunggu'::character varying
);


ALTER TABLE public.janji_temu OWNER TO postgres;

--
-- Name: janji_temu_id_janji_temu_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.janji_temu_id_janji_temu_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.janji_temu_id_janji_temu_seq OWNER TO postgres;

--
-- Name: janji_temu_id_janji_temu_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.janji_temu_id_janji_temu_seq OWNED BY public.janji_temu.id_janji_temu;


--
-- Name: pasien; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pasien (
    id_pasien integer NOT NULL,
    nama_pasien character varying(100) NOT NULL,
    tempat_lahir character varying(100),
    tanggal_lahir date,
    jenis_kelamin character varying(20),
    alamat text,
    nomor_telepon character varying(20)
);


ALTER TABLE public.pasien OWNER TO postgres;

--
-- Name: pasien_id_pasien_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pasien_id_pasien_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.pasien_id_pasien_seq OWNER TO postgres;

--
-- Name: pasien_id_pasien_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pasien_id_pasien_seq OWNED BY public.pasien.id_pasien;


--
-- Name: tagihan; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tagihan (
    id_tagihan integer NOT NULL,
    id_janji_temu integer NOT NULL,
    total_biaya numeric(12,2),
    status_pembayaran character varying(20) DEFAULT 'Belum Lunas'::character varying
);


ALTER TABLE public.tagihan OWNER TO postgres;

--
-- Name: tagihan_id_tagihan_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tagihan_id_tagihan_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.tagihan_id_tagihan_seq OWNER TO postgres;

--
-- Name: tagihan_id_tagihan_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tagihan_id_tagihan_seq OWNED BY public.tagihan.id_tagihan;


--
-- Name: dokter id_dokter; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dokter ALTER COLUMN id_dokter SET DEFAULT nextval('public.dokter_id_dokter_seq'::regclass);


--
-- Name: janji_temu id_janji_temu; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.janji_temu ALTER COLUMN id_janji_temu SET DEFAULT nextval('public.janji_temu_id_janji_temu_seq'::regclass);


--
-- Name: pasien id_pasien; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pasien ALTER COLUMN id_pasien SET DEFAULT nextval('public.pasien_id_pasien_seq'::regclass);


--
-- Name: tagihan id_tagihan; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tagihan ALTER COLUMN id_tagihan SET DEFAULT nextval('public.tagihan_id_tagihan_seq'::regclass);


--
-- Data for Name: dokter; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.dokter (id_dokter, nama_dokter, spesialisasi, nomor_telepon) FROM stdin;
1	dr. Andi	Umum	081111111111
2	dr. Siti	Anak	082222222222
3	dr. Budi	Gigi	083333333333
\.


--
-- Data for Name: janji_temu; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.janji_temu (id_janji_temu, id_pasien, id_dokter, tanggal_janji, keluhan, status) FROM stdin;
1	1	1	2026-06-22	Demam	Menunggu
2	2	2	2026-06-22	Batuk	Selesai
3	3	3	2026-06-23	Sakit Gigi	Diproses
4	5	1	2026-06-22	Sakit kepala	Selesai
\.


--
-- Data for Name: pasien; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pasien (id_pasien, nama_pasien, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat, nomor_telepon) FROM stdin;
2	Siti Aminah	Jakarta	1999-08-21	Perempuan	Jakarta	081234567891
3	Andi Saputra	Bandung	2001-02-10	Laki-laki	Bandung	081234567892
5	Imam Qurrata	Aceh	2011-11-11	Laki-laki	Aceh	089978997866
7	Rizki	Pundong	2004-02-12	Laki-laki	Bantul	09876567890
1	Budi Santoso	Yogyakarta	2000-05-12	Laki-laki	Yogyakarta	081234567890
\.


--
-- Data for Name: tagihan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tagihan (id_tagihan, id_janji_temu, total_biaya, status_pembayaran) FROM stdin;
2	2	200000.00	Lunas
3	3	175000.00	Belum Lunas
1	1	150000.00	Belum Lunas
\.


--
-- Name: dokter_id_dokter_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.dokter_id_dokter_seq', 3, true);


--
-- Name: janji_temu_id_janji_temu_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.janji_temu_id_janji_temu_seq', 4, true);


--
-- Name: pasien_id_pasien_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pasien_id_pasien_seq', 56, true);


--
-- Name: tagihan_id_tagihan_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tagihan_id_tagihan_seq', 3, true);


--
-- Name: dokter dokter_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dokter
    ADD CONSTRAINT dokter_pkey PRIMARY KEY (id_dokter);


--
-- Name: janji_temu janji_temu_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.janji_temu
    ADD CONSTRAINT janji_temu_pkey PRIMARY KEY (id_janji_temu);


--
-- Name: pasien pasien_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pasien
    ADD CONSTRAINT pasien_pkey PRIMARY KEY (id_pasien);


--
-- Name: tagihan tagihan_id_janji_temu_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tagihan
    ADD CONSTRAINT tagihan_id_janji_temu_key UNIQUE (id_janji_temu);


--
-- Name: tagihan tagihan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tagihan
    ADD CONSTRAINT tagihan_pkey PRIMARY KEY (id_tagihan);


--
-- Name: janji_temu fk_dokter; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.janji_temu
    ADD CONSTRAINT fk_dokter FOREIGN KEY (id_dokter) REFERENCES public.dokter(id_dokter);


--
-- Name: tagihan fk_janji_temu; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tagihan
    ADD CONSTRAINT fk_janji_temu FOREIGN KEY (id_janji_temu) REFERENCES public.janji_temu(id_janji_temu);


--
-- Name: janji_temu fk_pasien; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.janji_temu
    ADD CONSTRAINT fk_pasien FOREIGN KEY (id_pasien) REFERENCES public.pasien(id_pasien);


--
-- PostgreSQL database dump complete
--

\unrestrict 8P0kNWaqofh35TiNLEkly3Y0DqvjuMbAApzepHdgBBzpOfcGRsGbBcDVuRIv3pv


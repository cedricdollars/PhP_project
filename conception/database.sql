-- ============================================================== --
--  Nom de SGBD :  MySQL 5.0                                      --
--  Date de création :  20/04/2017 16:12:19                       --
-- ============================================================== --


drop table if exists CLIENT;

drop table if exists COMMANDE;

drop table if exists COMMANDE_PRODUIT;

drop table if exists FOURNISSEUR;

drop table if exists MALADIE;

drop table if exists PAYS;

drop table if exists PRODUIT;

drop table if exists PRODUIT_MALADIE;

drop table if exists STOCK;

drop table if exists TYPE_PRODUIT;

drop table if exists VENTE;

drop table if exists VENTE_PRODUIT;

-- ============================================================== --
--  Table : CLIENT                                                --
-- ============================================================== --
create table CLIENT
(
   ID                   int not null auto_increment,
   NOM                  varchar(100) not null,
   TELEPHONE            varchar(15),
   EMAIL                varchar(60),
   primary key (ID)
);

-- ============================================================== --
--  Table : COMMANDE                                              --
-- ============================================================== --
create table COMMANDE
(
   ID                   int not null auto_increment,
   ID_CLIENT            int not null,
   REFERENCE            varchar(30) not null,
   MONTANT              decimal(10,2) not null,
   DATE                 timestamp default current_timestamp,
   TVA                  real,
   primary key (ID)
);

-- ============================================================== --
--  Table : COMMANDE_PRODUIT                                      --
-- ============================================================== --
create table COMMANDE_PRODUIT
(
   ID_COMMANDE          int not null,
   ID_PRODUIT           int not null,
   primary key (ID_COMMANDE, ID_PRODUIT)
);

-- ============================================================== --
--  Table : FOURNISSEUR                                           --
-- ============================================================== --
create table FOURNISSEUR
(
   ID                   int not null auto_increment,
   NOM                  varchar(100) not null,
   ADRESSE              varchar(256) not null,
   primary key (ID)
);

-- ============================================================== --
--  Table : MALADIE                                               --
-- ============================================================== --
create table MALADIE
(
   ID                   int not null auto_increment,
   NOM                  varchar(100) not null,
   DESCRIPTION          text,
   primary key (ID)
);

-- ============================================================== --
--  Table : PAYS                                                  --
-- ============================================================== --
create table PAYS
(
   ID                   int not null auto_increment,
   CODE                 varchar(10) not null,
   NOM                  varchar(100),
   primary key (ID)
);

-- ============================================================== --
--  Table : PRODUIT                                               --
-- ============================================================== --
create table PRODUIT
(
   ID                   int not null auto_increment,
   ID_FOURNISSEUR       int not null,
   ID_TYPE_PRODUIT      int not null,
   ID_PAYS              int not null,
   REFERENCE            varchar(30) not null,
   LIBELLE              varchar(100),
   PAYS_ORIGINE         varchar(30),
   DESCRIPTION          text,
   primary key (ID)
);

-- ============================================================== --
--  Table : PRODUIT_MALADIE                                       --
-- ============================================================== --
create table PRODUIT_MALADIE
(
   ID_PRODUIT           int not null,
   ID_MALADIE           int not null,
   primary key (ID_PRODUIT, ID_MALADIE)
);

-- ============================================================== --
--  Table : STOCK                                                 --
-- ============================================================== --
create table STOCK
(
   ID                   int not null auto_increment,
   ID_PRODUIT           int not null,
   QUANTITE_PRECEDENTE  float not null,
   QUANTITE             real not null,
   NOUVELLE_QUANTITE    float not null,
   DATE_RECEPTION       timestamp default current_timestamp,
   primary key (ID)
);

-- ============================================================== --
--  Table : TYPE_PRODUIT                                          --
-- ============================================================== --
create table TYPE_PRODUIT
(
   ID                   int not null auto_increment,
   NOM                  varchar(100) not null,
   DESCRIPTION          text,
   primary key (ID)
);

-- ============================================================== --
--  Table : VENTE                                                 --
-- ============================================================== --
create table VENTE
(
   ID                   int not null auto_increment,
   ID_CLIENT            int not null,
   MONTANT              decimal(10,2) not null,
   DATE                 timestamp default current_timestamp,
   primary key (ID)
);

-- ============================================================== --
--  Table : VENTE_PRODUIT                                         --
-- ============================================================== --
create table VENTE_PRODUIT
(
   ID_VENTE             int not null,
   ID_PRODUIT           int not null,
   PU                   decimal(10,2) not null,
   QUANTITE             real not null,
   primary key (ID_VENTE, ID_PRODUIT)
);

alter table COMMANDE add constraint FK_PASSER foreign key (ID_CLIENT)
      references CLIENT (ID) on delete restrict on update restrict;

alter table COMMANDE_PRODUIT add constraint FK_AVOIR foreign key (ID_PRODUIT)
      references PRODUIT (ID) on delete restrict on update restrict;

alter table COMMANDE_PRODUIT add constraint FK_AVOIR2 foreign key (ID_COMMANDE)
      references COMMANDE (ID) on delete restrict on update restrict;

alter table PRODUIT add constraint FK_APPARTENIR foreign key (ID_TYPE_PRODUIT)
      references TYPE_PRODUIT (ID) on delete restrict on update restrict;

alter table PRODUIT add constraint FK_LIVRER foreign key (ID_FOURNISSEUR)
      references FOURNISSEUR (ID) on delete restrict on update restrict;

alter table PRODUIT add constraint FK_PROVENIR foreign key (ID_PAYS)
      references PAYS (ID) on delete restrict on update restrict;

alter table PRODUIT_MALADIE add constraint FK_DESTINER foreign key (ID_MALADIE)
      references MALADIE (ID) on delete restrict on update restrict;

alter table PRODUIT_MALADIE add constraint FK_DESTINER2 foreign key (ID_PRODUIT)
      references PRODUIT (ID) on delete restrict on update restrict;

alter table STOCK add constraint FK_CONTENIR foreign key (ID_PRODUIT)
      references PRODUIT (ID) on delete restrict on update restrict;

alter table VENTE add constraint FK_CONCERNER foreign key (ID_CLIENT)
      references CLIENT (ID) on delete restrict on update restrict;

alter table VENTE_PRODUIT add constraint FK_CONTENIR1 foreign key (ID_PRODUIT)
      references PRODUIT (ID) on delete restrict on update restrict;

alter table VENTE_PRODUIT add constraint FK_CONTENIR2 foreign key (ID_VENTE)
      references VENTE (ID) on delete restrict on update restrict;

